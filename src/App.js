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

function HomePage() {
  return (
    <div style={{ minHeight: '100vh', background: 'linear-gradient(135deg, #f5f7fa 0%, #e4ecfb 100%)', padding: '48px 20px' }}>
      <div style={{ maxWidth: 960, margin: '0 auto', textAlign: 'center' }}>
        <h1 style={{ marginBottom: 12 }}>Wamdin Alumni Portal</h1>
        <p style={{ maxWidth: 620, margin: '0 auto 24px', color: '#374151', lineHeight: 1.6 }}>
          Connect with fellow alumni, explore events, collaborate in real time, and share resources in one place.
        </p>

        <div style={{ display: 'flex', gap: 12, justifyContent: 'center', flexWrap: 'wrap', marginBottom: 32 }}>
          <Link to="/login" style={{ padding: '10px 18px', borderRadius: 8, textDecoration: 'none', background: '#2563eb', color: '#fff' }}>
            Login
          </Link>
          <Link to="/signup" style={{ padding: '10px 18px', borderRadius: 8, textDecoration: 'none', border: '1px solid #2563eb', color: '#2563eb' }}>
            Create Account
          </Link>
          <Link to="/dashboard" style={{ padding: '10px 18px', borderRadius: 8, textDecoration: 'none', border: '1px solid #cbd5e1', color: '#0f172a' }}>
            Go to Dashboard
          </Link>
        </div>

        <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', textAlign: 'left' }}>
          <div style={{ background: '#fff', borderRadius: 12, padding: 16, boxShadow: '0 2px 10px rgba(15, 23, 42, 0.06)' }}>
            <h3 style={{ marginTop: 0 }}>Alumni Directory</h3>
            <p style={{ marginBottom: 0 }}>Search and filter alumni by skills, location, and institution.</p>
          </div>
          <div style={{ background: '#fff', borderRadius: 12, padding: 16, boxShadow: '0 2px 10px rgba(15, 23, 42, 0.06)' }}>
            <h3 style={{ marginTop: 0 }}>Events</h3>
            <p style={{ marginBottom: 0 }}>Create and register for events directly from the portal.</p>
          </div>
          <div style={{ background: '#fff', borderRadius: 12, padding: 16, boxShadow: '0 2px 10px rgba(15, 23, 42, 0.06)' }}>
            <h3 style={{ marginTop: 0 }}>Messaging</h3>
            <p style={{ marginBottom: 0 }}>Chat instantly with other members with real-time updates.</p>
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
      <Notification />
      <Routes>
        <Route path="/" element={<HomePage />} />
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
      </Routes>
    </Router>
  );
}

export default App;
