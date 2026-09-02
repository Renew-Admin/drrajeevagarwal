import { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate, useLocation, useParams } from 'react-router-dom';

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
import { pagesData } from './data/pages_data';

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

/**
 * The single canonical route for everything at the site root: /<slug>/.
 *
 * Service landing pages (src/data/pages_data.js) and blog articles share this
 * level, so one route decides which page a slug belongs to. Service pages are
 * a closed, bundled set and win; anything else is treated as an article —
 * BlogPost resolves it against the bundled posts and Supabase, and renders the
 * 404 page if neither knows the slug. There is deliberately no /blog/:slug
 * route any more: that form 301s to /<slug>/ (src/worker.js), so it can never
 * render a duplicate of the article.
 */
function RootSlugPage({ onBookClick }) {
  const { slug } = useParams();
  const cleanSlug = slug ? slug.trim().replace(/\/$/, '') : '';

  if (pagesData[cleanSlug]) {
    return <ServicePage onBookClick={onBookClick} />;
  }

  return <BlogPost />;
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
  const [chatState, setChatState] = useState({ open: false, teaser: false });

  useEffect(() => {
    const handleMessage = (e) => {
      if (e.data && e.data.type === 'drrajeev-chat:resize') {
        setChatState({
          open: !!e.data.open,
          teaser: !!e.data.teaser,
        });
      }
    };

    window.addEventListener('message', handleMessage);
    return () => window.removeEventListener('message', handleMessage);
  }, []);

  if (isAdminRoute) {
    return null;
  }

  let stateClass = 'is-closed';
  if (chatState.open) {
    stateClass = 'is-open';
  } else if (chatState.teaser) {
    stateClass = 'is-teaser';
  }

  return (
    <>
      <iframe
        className={`ra-chatbot-frame ${stateClass}`}
        src="https://dr-rajeev-agarwal-chatbot.onrender.com"
        title="AI chatbot"
      />

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
          
          {/* Blog listing. Articles live at /<slug>/ — see RootSlugPage below. */}
          <Route path="/blog" element={<BlogList />} />
          
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

          {/* Site-root catch-all: service landing pages and blog articles (/<slug>/) */}
          <Route path="/all-services" element={<AllServices onBookClick={openBookModal} />} />
          <Route path="/success-stories" element={<SuccessStories onBookClick={openBookModal} />} />
          <Route path="/courses" element={<Courses onBookClick={openBookModal} />} />
          <Route path="/:slug" element={<RootSlugPage onBookClick={openBookModal} />} />
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
