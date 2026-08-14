import { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate, useLocation } from 'react-router-dom';

// Components
import Header from './components/Header';
import Footer from './components/Footer';
import PopupFormWrapper from './components/PopupFormWrapper';
import AppointmentForm from './components/AppointmentForm';
import GlobalAnnouncementBar from './components/GlobalAnnouncementBar';
import GlobalPromotionPopup from './components/GlobalPromotionPopup';
import WebMcpTools from './components/WebMcpTools';
import { usePageTracking } from './hooks/usePageTracking';
import { useVersionCheck } from './hooks/useVersionCheck';

// Pages
import Home from './pages/Home';
import About from './pages/About';
import Preconception from './pages/Preconception';
import PreconceptionWorkshop from './pages/PreconceptionWorkshop';
import AdminDashboard from './pages/AdminDashboard';
import AllServices from './pages/AllServices';
import BlogList from './pages/BlogList';
import BlogPost from './pages/BlogPost';
import Doctors from './pages/Doctors';
import DoctorProfile from './components/DoctorProfile';
import BookAppointment from './pages/BookAppointment';
import ServicePage from './pages/ServicePage';
import PolicyPage from './pages/PolicyPage';
import SuccessStories from './pages/SuccessStories';
import Courses from './pages/Courses';
import NotFound from './pages/NotFound';

// Menopause Care hub (/menopause-care/*)
import MenopauseCareHub from './pages/menopause/MenopauseCareHub';
import SymptomsAndQuiz from './pages/menopause/SymptomsAndQuiz';
import HrtGuide from './pages/menopause/HrtGuide';
import TestsAndDiagnostics from './pages/menopause/TestsAndDiagnostics';
import DietExerciseLifestyle from './pages/menopause/DietExerciseLifestyle';
import CareTeam from './pages/menopause/CareTeam';
import ArticlesAndVideos from './pages/menopause/ArticlesAndVideos';
import { MENOPAUSE_PAGES } from './data/menopauseCare';

/**
 * Component per menopause-care route, keyed by the `key` in
 * src/data/menopauseCare.js. That file is the single source of truth for the
 * paths themselves, the nav, the sitemap and the JSON-LD — adding an entry
 * there plus a component here is all a new sub-page needs.
 */
const MENOPAUSE_PAGE_COMPONENTS = {
  hub: MenopauseCareHub,
  symptoms: SymptomsAndQuiz,
  hrt: HrtGuide,
  tests: TestsAndDiagnostics,
  lifestyle: DietExerciseLifestyle,
  team: CareTeam,
  library: ArticlesAndVideos,
};

// Scroll Restoration helper
function ScrollToTop() {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);
  return null;
}

function PageTracking() {
  usePageTracking();
  return null;
}

function isAdminPath(pathname) {
  return pathname === '/admin' || pathname.startsWith('/admin/');
}

function SiteChrome({ children, onBookClick }) {
  const location = useLocation();
  const isExactHome = location.pathname === '/';
  const isAdminRoute = isAdminPath(location.pathname);

  if (isExactHome || isAdminRoute) {
    return children;
  }

  return (
    <>
      <Header onBookClick={onBookClick} />
      <main style={{ minHeight: '80vh' }}>
        {children}
      </main>
      <Footer />
    </>
  );
}

function GlobalSiteWidgets({ isBookOpen, closeBookModal }) {
  const location = useLocation();
  const isAdminRoute = isAdminPath(location.pathname);

  if (isAdminRoute) {
    return null;
  }

  return (
    <>
      <a
        className="ra-whatsapp-float"
        href="https://wa.me/916292269060?text=Hello%20Dr.%20Rajeev%20Agarwal%27s%20team"
        target="_blank"
        rel="noreferrer"
        aria-label="Chat with Dr. Rajeev Agarwal on WhatsApp"
        title="Chat on WhatsApp"
      >
        <svg viewBox="0 0 32 32" aria-hidden="true">
          <path d="M16 3.2a12.7 12.7 0 0 0-10.9 19.2L3.4 28.8l6.6-1.7A12.8 12.8 0 1 0 16 3.2Zm0 23.3a10.5 10.5 0 0 1-5.3-1.4l-.4-.2-3.9 1 1-3.8-.3-.4A10.5 10.5 0 1 1 16 26.5Zm5.8-7.8c-.3-.2-1.8-.9-2.1-1s-.5-.2-.7.2-.8 1-.9 1.2-.3.2-.6.1a8.5 8.5 0 0 1-2.5-1.5 9.4 9.4 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.4.3-.6s0-.4 0-.6-.7-1.7-.9-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.1 1.1-1.1 2.7s1.1 3.1 1.3 3.3c.2.2 2.2 3.4 5.4 4.7.8.3 1.4.5 1.9.6.8.2 1.5.1 2.1.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.3-.6-.4Z" />
        </svg>
      </a>

      {/* Reusable Popup appointment scheduler */}
      <PopupFormWrapper
        isOpen={isBookOpen}
        onClose={closeBookModal}
        title="Schedule Clinic Appointment"
      >
        <AppointmentForm formName="Global Sticky Header Form" onSuccess={closeBookModal} />
      </PopupFormWrapper>
    </>
  );
}

/**
 * Everything below the router. Split out from App so the build-time
 * prerenderer (scripts/prerender.mjs) can render it inside a StaticRouter,
 * while the browser keeps using BrowserRouter below.
 */
export function AppRoutes() {
  const [isBookOpen, setIsBookOpen] = useState(false);

  const openBookModal = () => setIsBookOpen(true);
  const closeBookModal = () => setIsBookOpen(false);

  return (
    <>
      <PageTracking />
      <ScrollToTop />
      <GlobalAnnouncementBar />
      <GlobalPromotionPopup />
      <WebMcpTools onBookClick={openBookModal} />

      <SiteChrome onBookClick={openBookModal}>
        <Routes>
          {/* Main Pages */}
          <Route path="/" element={<Home onBookClick={openBookModal} />} />
          <Route path="/about-me" element={<About onBookClick={openBookModal} />} />
          <Route path="/preconception" element={<Preconception />} />
          <Route path="/preconception-care/*" element={<Navigate to="/preconception" replace />} />
          <Route path="/preconception-workshop" element={<PreconceptionWorkshop />} />
          
          {/* Admin Dashboard */}
          <Route path="/admin/*" element={<AdminDashboard />} />
          
          {/* Blog Routes */}
          <Route path="/blog" element={<BlogList />} />
          <Route path="/blog/:slug" element={<BlogPost />} />
          
          {/* Doctor Team & Individual Profiles */}
          <Route path="/doctors" element={<Doctors />} />
          <Route path="/doctors/:slug" element={<DoctorProfile onBookClick={openBookModal} />} />
          
          {/* Dedicated Booking page */}
          <Route path="/book-an-appointment" element={<BookAppointment />} />
          
          {/* Policies Routing */}
          <Route path="/privacy-policy" element={<PolicyPage />} />
          <Route path="/terms-conditions" element={<PolicyPage />} />
          <Route path="/disclaimer-policy" element={<PolicyPage />} />
          <Route path="/cancellation-refund-policy" element={<PolicyPage />} />
          
          {/* Menopause Care hub. Declared before the /:slug catch-all so the
              hub itself is not treated as a service page. */}
          {MENOPAUSE_PAGES.map((page) => {
            const PageComponent = MENOPAUSE_PAGE_COMPONENTS[page.key];
            return PageComponent ? (
              <Route
                key={page.path}
                path={page.path}
                element={<PageComponent onBookClick={openBookModal} />}
              />
            ) : null;
          })}

          {/* Dynamic Services / Landing Pages Catch-All (WordPress replication) */}
          <Route path="/all-services" element={<AllServices onBookClick={openBookModal} />} />
          <Route path="/success-stories" element={<SuccessStories onBookClick={openBookModal} />} />
          <Route path="/courses" element={<Courses onBookClick={openBookModal} />} />
          <Route path="/:slug" element={<ServicePage onBookClick={openBookModal} />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </SiteChrome>

      <GlobalSiteWidgets isBookOpen={isBookOpen} closeBookModal={closeBookModal} />
    </>
  );
}

export default function App() {
  useVersionCheck();

  return (
    <Router>
      <AppRoutes />
    </Router>
  );
}
