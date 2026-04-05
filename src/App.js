import React, { useRef } from 'react';
import { BrowserRouter as Router, Routes, Route, useLocation, useParams, Navigate } from 'react-router-dom';





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

function toHtmlMirror(pathname) {
  return pathname.replace(/\.php(\?.*)?$/i, '.html$1');
}

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
  const frameRef = useRef(null);

  const handleFrameLoad = () => {
    try {
      const frame = frameRef.current;
      const doc = frame?.contentDocument;
      if (!doc) {
        return;
      }

      const loadingOverlay = doc.getElementById('loading-icon-bx');
      if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
      }

      if (doc.body) {
        doc.body.style.opacity = '1';
        doc.body.style.visibility = 'visible';
        doc.body.style.display = 'block';
      }

      const wrappers = doc.querySelectorAll('#wrapper, .page-wraper, .page-wraper, main');
      wrappers.forEach((el) => {
        el.style.opacity = '1';
        el.style.visibility = 'visible';
      });

      // Keep legacy navigation browseable in static hosting by mapping PHP links to HTML mirrors.
      const anchors = doc.querySelectorAll('a[href]');
      anchors.forEach((anchor) => {
        const href = anchor.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
          return;
        }

        if (/\.php(\?|$)/i.test(href)) {
          anchor.setAttribute('href', toHtmlMirror(href));
        }
      });
    } catch (error) {
      // Keep rendering even when frame internals are inaccessible.
      // eslint-disable-next-line no-console
      console.warn('Legacy frame post-load fix skipped:', error);
    }
  };

  return (
    <div style={{ minHeight: '100vh', background: '#fff' }}>
      <iframe
        ref={frameRef}
        title={title}
        src={src}
        onLoad={handleFrameLoad}
        style={{ width: '100%', minHeight: '100vh', border: 'none', display: 'block' }}
      />
    </div>
  );
}

function LegacyPhpRoute() {
  const { legacyPhp } = useParams();

  if (!legacyPhp || !legacyPhp.toLowerCase().endsWith('.php')) {
    return <Navigate to="/" replace />;
  }

  return <LegacyPageFrame src={toHtmlMirror(`/wamdevin-full/${legacyPhp}`)} title={legacyPhp} />;
}

function LegacyNestedPhpRoute() {
  const { folder, legacyPhp } = useParams();
  const allowedFolders = new Set(['admin', 'alumni', 'alumni-api', 'alumni-portal']);

  if (!folder || !allowedFolders.has(folder)) {
    return <Navigate to="/" replace />;
  }

  if (!legacyPhp || !legacyPhp.toLowerCase().endsWith('.php')) {
    return <Navigate to="/" replace />;
  }

  return <LegacyPageFrame src={toHtmlMirror(`/wamdevin-full/${folder}/${legacyPhp}`)} title={`${folder}/${legacyPhp}`} />;
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
          <Route path="/about" element={<LegacyPageFrame src="/wamdevin-full/about.html" title="About" />} />
          <Route path="/leadership" element={<LegacyPageFrame src="/wamdevin-full/leadership.html" title="Leadership" />} />
          <Route path="/services" element={<LegacyPageFrame src="/wamdevin-full/service.html" title="Services" />} />
          <Route path="/membership" element={<LegacyPageFrame src="/wamdevin-full/membership.html" title="Membership" />} />
          <Route path="/partners" element={<LegacyPageFrame src="/wamdevin-full/partners.html" title="Partners" />} />
          <Route path="/projects" element={<ProjectsPortal />} />
          <Route path="/training" element={<LegacyPageFrame src="/wamdevin-full/trainners.html" title="Training" />} />
          <Route path="/research" element={<LegacyPageFrame src="/wamdevin-full/research.html" title="Research" />} />
          <Route path="/publication" element={<LegacyPageFrame src="/wamdevin-full/publication.html" title="Publication" />} />
          <Route path="/consultancy" element={<LegacyPageFrame src="/wamdevin-full/consultancy.html" title="Consultancy" />} />
          <Route path="/gallery" element={<LegacyPageFrame src="/wamdevin-full/gallery.html" title="Gallery" />} />
          <Route path="/gallery-modern" element={<LegacyPageFrame src="/wamdevin-full/gallery.html" title="Gallery" />} />
          <Route path="/contact" element={<LegacyPageFrame src="/wamdevin-full/contact.html" title="Contact" />} />
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
          <Route path="/:legacyPhp" element={<LegacyPhpRoute />} />
          <Route path="/:folder/:legacyPhp" element={<LegacyNestedPhpRoute />} />
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
