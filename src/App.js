import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';





import AlumniDirectory from '../pages/AlumniDirectory';
import Messaging from '../pages/Messaging';
import Events from '../pages/Events';
import Resources from '../pages/Resources';
import AdminDashboard from '../pages/AdminDashboard';
import Login from '../pages/Login';
import Signup from '../pages/Signup';
import Dashboard from '../pages/Dashboard';
import Profile from '../pages/Profile';
import ProtectedRoute from '../components/ProtectedRoute';
import AdminRoute from '../components/AdminRoute';
import Notification from '../components/Notification';

function App() {
  return (
    <Router>
      <Notification />
      <Routes>
        <Route path="/" element={<div>Welcome to Wamdin Alumni Portal</div>} />
        <Route path="/login" element={<Login />} />
        <Route path="/signup" element={<Signup />} />
        <Route path="/dashboard" element={<ProtectedRoute><Dashboard /></ProtectedRoute>} />
        <Route path="/profile" element={<ProtectedRoute><Profile /></ProtectedRoute>} />
        <Route path="/alumni" element={<ProtectedRoute><AlumniDirectory /></ProtectedRoute>} />
        <Route path="/messaging" element={<ProtectedRoute><Messaging /></ProtectedRoute>} />
        <Route path="/events" element={<ProtectedRoute><Events /></ProtectedRoute>} />
        <Route path="/resources" element={<ProtectedRoute><Resources /></ProtectedRoute>} />
        <Route path="/admin" element={<AdminRoute><AdminDashboard /></AdminRoute>} />
      </Routes>
    </Router>
  );
}

export default App;
