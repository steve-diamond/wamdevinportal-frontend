import React, { useRef, lazy, Suspense } from 'react';
import { BrowserRouter as Router, Routes, Route, useParams, Navigate } from 'react-router-dom';

// ── Lazy-loaded portal pages (heavy data pages load on demand) ──
const AlumniDirectory    = lazy(() => import('./pages/AlumniDirectory'));
const DirectoryPage      = lazy(() => import('./pages/DirectoryPage'));
const Messaging          = lazy(() => import('./pages/Messaging'));
const Events             = lazy(() => import('./pages/Events'));
const EventPage          = lazy(() => import('./pages/EventPage'));
const MessagesPage       = lazy(() => import('./pages/MessagesPage'));
const Resources          = lazy(() => import('./pages/Resources'));
const AdminDashboard     = lazy(() => import('./pages/AdminDashboard'));
const Dashboard          = lazy(() => import('./pages/Dashboard'));
const Profile            = lazy(() => import('./pages/Profile'));
const Signup             = lazy(() => import('./pages/Signup'));
const ContactPortal      = lazy(() => import('./pages/ContactPortal'));
const ProjectsPortal     = lazy(() => import('./pages/ProjectsPortal'));
const GalleryPortal      = lazy(() => import('./pages/GalleryPortal'));
const PortalAccess       = lazy(() => import('./pages/PortalAccess'));

// ── Eagerly-loaded (lightweight, needed immediately) ──
import Login from './pages/Login';
import ProtectedRoute from './components/ProtectedRoute';
import AdminRoute from './components/AdminRoute';
import Notification from './components/Notification';
import useStore from './store/useStore';
import LegacyHeader from './components/LegacyHeader';
import LegacyFooter from './components/LegacyFooter';

/** Accessible full-page loading fallback */
function PageLoader() {
  return (
    <div
      role="status"
      aria-label="Loading page"
      style={{
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        minHeight: '60vh', flexDirection: 'column', gap: 12,
        color: 'var(--text-muted, #94a3b8)',
      }}
    >
      <div
        aria-hidden="true"
        style={{
          width: 36, height: 36, border: '3px solid #e2e8f0',
          borderTopColor: '#0f4d92', borderRadius: '50%',
          animation: 'spin 0.75s linear infinite',
        }}
      />
      <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
      <span>Loading…</span>
    </div>
  );
}

function toHtmlMirror(pathname) {
  return pathname.replace(/\.php(\?.*)?$/i, '.html$1');
}

function LegacyHomePage() {
  return <LegacyPageFrame src="/wamdevin-full/index.html" title="Wamdevin Legacy Home" />;
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

      // Ensure legacy pages do not render a second header/footer inside the shared app shell.
      const legacyChrome = doc.querySelectorAll(
        'header.header, .top-bar, .sticky-header, footer, .footer-top, .footer-bottom'
      );
      legacyChrome.forEach((el) => {
        el.style.display = 'none';
      });

      // Keep legacy navigation browseable in static hosting by mapping PHP links to HTML mirrors.
      const anchors = doc.querySelectorAll('a[href]');
      const topRouteMap = {
        'about.php': '/about',
        'leadership.php': '/leadership',
        'service.php': '/services',
        'gallery.php': '/gallery',
        'contact.php': '/contact',
        'projects.php': '/projects',
        'membership.php': '/membership',
        'partners.php': '/partners',
        'trainners.php': '/training',
        'research.php': '/research',
        'publication.php': '/publication',
        'consultancy.php': '/consultancy',
        'login.php': '/portal',
        'register.php': '/signup'
      };

      anchors.forEach((anchor) => {
        const href = anchor.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
          return;
        }

        const cleanHref = href.replace(/^\.\//, '').replace(/^\//, '').split('?')[0].split('#')[0];
        const normalized = cleanHref.replace(/^wamdevin-full\//i, '');

        if (topRouteMap[normalized]) {
          anchor.setAttribute('href', topRouteMap[normalized]);
          anchor.setAttribute('target', '_top');
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

  return (
    <div className="app-shell">
      <Notification />
      <LegacyHeader />
      <main className="app-content">
        <Suspense fallback={<PageLoader />}>
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
            <Route path="/gallery" element={<GalleryPortal />} />
            <Route path="/gallery-modern" element={<GalleryPortal />} />
            <Route path="/contact" element={<ContactPortal />} />
            <Route path="/contact-modern" element={<ContactPortal />} />
            <Route path="/login" element={<Navigate to="/portal/alumni" replace />} />
            <Route path="/signup" element={<Signup />} />
            <Route path="/portal" element={<PortalAccess />} />
            <Route path="/portal/alumni" element={<Login portalRole="alumni" />} />
            <Route path="/portal/membership" element={<Login portalRole="membership" />} />
            <Route path="/portal/admin" element={<Login portalRole="admin" />} />
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
            <Route path="/:legacyPhp" element={<LegacyPhpRoute />} />
            <Route path="/:folder/:legacyPhp" element={<LegacyNestedPhpRoute />} />
          </Routes>
        </Suspense>
      </main>

      <LegacyFooter />
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
