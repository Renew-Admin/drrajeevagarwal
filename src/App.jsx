import { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate, useLocation } from 'react-router-dom';

// Components
import Header from './components/Header';
import Footer from './components/Footer';
import PopupFormWrapper from './components/PopupFormWrapper';
import AppointmentForm from './components/AppointmentForm';
import GlobalAnnouncementBar from './components/GlobalAnnouncementBar';

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

// Scroll Restoration helper
function ScrollToTop() {
  const { pathname } = useLocation();
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);
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
  const [chatState, setChatState] = useState({ open: false, teaser: false });

  useEffect(() => {
    const handleMessage = (e) => {
      if (e.data && e.data.type === 'drrajeev-chat:resize') {
        setChatState({
          open: !!e.data.open,
          teaser: !!e.data.teaser
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
        title="Chatbot"
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

export default function App() {
  const [isBookOpen, setIsBookOpen] = useState(false);

  const openBookModal = () => setIsBookOpen(true);
  const closeBookModal = () => setIsBookOpen(false);

  return (
    <Router>
      <ScrollToTop />
      <GlobalAnnouncementBar />

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
          
          {/* Dynamic Services / Landing Pages Catch-All (WordPress replication) */}
          <Route path="/all-services" element={<AllServices onBookClick={openBookModal} />} />
          <Route path="/success-stories" element={<SuccessStories onBookClick={openBookModal} />} />
          <Route path="/courses" element={<Courses onBookClick={openBookModal} />} />
          <Route path="/:slug" element={<ServicePage onBookClick={openBookModal} />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </SiteChrome>

      <GlobalSiteWidgets isBookOpen={isBookOpen} closeBookModal={closeBookModal} />
    </Router>
  );
}
