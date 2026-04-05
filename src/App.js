import React from 'react';
import { BrowserRouter as Router, Routes, Route, useLocation } from 'react-router-dom';





import AlumniDirectory from './pages/AlumniDirectory';
import DirectoryPage from './pages/DirectoryPage';
import Messaging from './pages/Messaging';
import Events from './pages/Events';
import EventPage from './pages/EventPage';
import MessagesPage from './pages/MessagesPage';
import Resources from './pages/Resources';
import AdminDashboard from './pages/AdminDashboard';
import Login from './pages/Login';
import Signup from './pages/Signup';
import Dashboard from './pages/Dashboard';
import Profile from './pages/Profile';
import ProtectedRoute from './components/ProtectedRoute';
import AdminRoute from './components/AdminRoute';
import Notification from './components/Notification';
import useStore from './store/useStore';
import WamdevinContentHub from './pages/WamdevinContentHub';
import LegacyHeader from './components/LegacyHeader';
import LegacyFooter from './components/LegacyFooter';
import ContactPortal from './pages/ContactPortal';
import ProjectsPortal from './pages/ProjectsPortal';

function LegacyHomePage() {
  return (
    <div style={{ minHeight: '100vh', background: '#fff' }}>
      <iframe
        title="Wamdevin Legacy Home"
        src="/wamdevin-full/index.html"
        style={{ width: '100%', minHeight: '100vh', border: 'none', display: 'block' }}
      />
    </div>
  );
}

function LegacyPageFrame({ src, title }) {
  return (
    <div style={{ minHeight: '100vh', background: '#fff' }}>
      <iframe
        title={title}
        src={src}
        style={{ width: '100%', minHeight: '100vh', border: 'none', display: 'block' }}
      />
    </div>
  );
}

function AppLayout() {
  const { user } = useStore();
  const location = useLocation();
  const isRootLegacyHome = location.pathname === '/';

  return (
    <div className="app-shell">
      <Notification />
      {!isRootLegacyHome && <LegacyHeader />}
      <main className="app-content">
        <Routes>
          <Route path="/" element={<LegacyHomePage />} />
          <Route path="/about" element={<LegacyPageFrame src="/wamdevin-full/about.php" title="About" />} />
          <Route path="/leadership" element={<LegacyPageFrame src="/wamdevin-full/leadership.php" title="Leadership" />} />
          <Route path="/services" element={<LegacyPageFrame src="/wamdevin-full/service.php" title="Services" />} />
          <Route path="/membership" element={<LegacyPageFrame src="/wamdevin-full/membership.php" title="Membership" />} />
          <Route path="/partners" element={<LegacyPageFrame src="/wamdevin-full/partners.php" title="Partners" />} />
          <Route path="/projects" element={<ProjectsPortal />} />
          <Route path="/training" element={<LegacyPageFrame src="/wamdevin-full/trainners.php" title="Training" />} />
          <Route path="/research" element={<LegacyPageFrame src="/wamdevin-full/research.php" title="Research" />} />
          <Route path="/publication" element={<LegacyPageFrame src="/wamdevin-full/publication.php" title="Publication" />} />
          <Route path="/consultancy" element={<LegacyPageFrame src="/wamdevin-full/consultancy.php" title="Consultancy" />} />
          <Route path="/gallery" element={<LegacyPageFrame src="/wamdevin-full/gallery.php" title="Gallery" />} />
          <Route path="/gallery-modern" element={<LegacyPageFrame src="/wamdevin-full/gallery.php" title="Gallery" />} />
          <Route path="/contact" element={<LegacyPageFrame src="/wamdevin-full/contact.php" title="Contact" />} />
          <Route path="/contact-modern" element={<ContactPortal />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />
          <Route path="/portal" element={<Login />} />
          <Route path="/dashboard" element={<ProtectedRoute><Dashboard user={user} /></ProtectedRoute>} />
          <Route path="/profile" element={<ProtectedRoute><Profile user={user} /></ProtectedRoute>} />
          <Route path="/alumni" element={<ProtectedRoute><AlumniDirectory /></ProtectedRoute>} />
          <Route path="/directory" element={<ProtectedRoute><DirectoryPage /></ProtectedRoute>} />
          <Route path="/messaging" element={<ProtectedRoute><Messaging user={user} /></ProtectedRoute>} />
          <Route path="/events" element={<ProtectedRoute><Events user={user} /></ProtectedRoute>} />
          <Route path="/events-live" element={<ProtectedRoute><EventPage /></ProtectedRoute>} />
          <Route path="/messages-live" element={<ProtectedRoute><MessagesPage /></ProtectedRoute>} />
          <Route path="/resources" element={<ProtectedRoute><Resources user={user} /></ProtectedRoute>} />
          <Route path="/admin" element={<AdminRoute><AdminDashboard /></AdminRoute>} />
          <Route path="/legacy-content" element={<WamdevinContentHub />} />
        </Routes>
      </main>

      {!isRootLegacyHome && (
        <LegacyFooter />
      )}
    </div>
  );
}

function App() {
  return (
    <Router>
      <AppLayout />
    </Router>
  );
}

export default App;
