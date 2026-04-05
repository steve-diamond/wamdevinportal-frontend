import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';





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
import TopNav from './components/TopNav';
import AboutPortal from './pages/AboutPortal';
import ContactPortal from './pages/ContactPortal';
import ProjectsPortal from './pages/ProjectsPortal';
import GalleryPortal from './pages/GalleryPortal';

function HomePage() {
  return (
    <div className="fade-up" style={{ minHeight: '100vh', padding: '42px 18px', background: 'linear-gradient(135deg, #0b1220 0%, #16335b 50%, #f8fbff 50%, #f8fbff 100%)' }}>
      <div style={{ maxWidth: 1100, margin: '0 auto', background: '#ffffff', borderRadius: 18, boxShadow: '0 20px 40px rgba(15, 23, 42, 0.18)', overflow: 'hidden' }}>
        <div style={{ position: 'relative' }}>
          <img
            src="/wamdevin-full/img/header.jpg"
            alt="Wamdevin banner"
            style={{ width: '100%', height: 260, objectFit: 'cover' }}
          />
          <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(180deg, rgba(0,0,0,0.15), rgba(0,0,0,0.5))' }} />
          <div style={{ position: 'absolute', left: 20, bottom: 20, color: '#fff' }}>
            <h1 style={{ margin: 0, fontSize: 34 }}>WAMDIN Alumni Portal</h1>
            <p style={{ margin: '8px 0 0', maxWidth: 580 }}>Fully integrated with Wamdevin legacy media and page content.</p>
          </div>
        </div>

        <div style={{ padding: 22 }}>
          <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap', marginBottom: 18 }}>
            <Link to="/login" style={{ textDecoration: 'none', background: '#1d4ed8', color: '#fff', padding: '10px 16px', borderRadius: 8 }}>Login</Link>
            <Link to="/signup" style={{ textDecoration: 'none', border: '1px solid #1d4ed8', color: '#1d4ed8', padding: '10px 16px', borderRadius: 8 }}>Create Account</Link>
            <Link to="/dashboard" style={{ textDecoration: 'none', border: '1px solid #94a3b8', color: '#0f172a', padding: '10px 16px', borderRadius: 8 }}>Dashboard</Link>
            <Link to="/legacy-content" style={{ textDecoration: 'none', background: '#0f172a', color: '#fff', padding: '10px 16px', borderRadius: 8 }}>Open Legacy Content Hub</Link>
          </div>

          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(230px, 1fr))', gap: 12 }}>
            <div style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
              <h3 style={{ marginTop: 0 }}>Alumni Directory</h3>
              <p style={{ marginBottom: 0 }}>Search and filter alumni records by name, country, institution, and skills.</p>
            </div>
            <div style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
              <h3 style={{ marginTop: 0 }}>Events and Registration</h3>
              <p style={{ marginBottom: 0 }}>Create and register events with real-time updates to participant activity.</p>
            </div>
            <div style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
              <h3 style={{ marginTop: 0 }}>Messaging and Resources</h3>
              <p style={{ marginBottom: 0 }}>Use direct messaging and access uploaded institutional resources.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

function App() {
  const { user } = useStore();

  return (
    <Router>
      <div className="app-shell">
        <Notification />
        <TopNav />
        <main className="app-content">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/about" element={<AboutPortal />} />
            <Route path="/projects" element={<ProjectsPortal />} />
            <Route path="/gallery-modern" element={<GalleryPortal />} />
            <Route path="/contact-modern" element={<ContactPortal />} />
            <Route path="/login" element={<Login />} />
            <Route path="/signup" element={<Signup />} />
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

        <footer className="portal-footer">
          <div className="portal-footer-inner">
            <span>WAMDIN Integrated Portal • Legacy + Modern Experience</span>
            <span className="portal-chip">/legacy-content</span>
          </div>
        </footer>
      </div>
    </Router>
  );
}

export default App;
