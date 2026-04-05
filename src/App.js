import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';





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

function App() {
  const { user } = useStore();

  return (
    <Router>
      <Notification />
      <Routes>
        <Route path="/" element={<div>Welcome to Wamdin Alumni Portal</div>} />
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
