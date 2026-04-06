import React, { useState } from 'react';
import useStore from '../store/useStore';
import { Link, useNavigate } from 'react-router-dom';
import api from '../api';

const Login = ({ portalRole = 'alumni' }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const { setUser, setLoading, setError, setNotification } = useStore();
  const navigate = useNavigate();
  const isAdminPortal = portalRole === 'admin';
  const isMembershipPortal = portalRole === 'membership';
  const loginTitle = isAdminPortal
    ? 'Admin Portal Login'
    : (isMembershipPortal ? 'Institutional Membership Login' : 'Alumni Portal Login');
  const loginSubtitle = isAdminPortal
    ? 'Authorized administrators only.'
    : (isMembershipPortal
      ? 'For institutional focal persons and membership representatives.'
      : 'Sign in to access your alumni dashboard and services.');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      const res = await api.post('/api/auth/login', { email, password });
      const loggedInUser = res.data.user;

      if (isAdminPortal && loggedInUser?.role !== 'admin') {
        setError('Admin access only. Please use an admin account.');
        setNotification('Access denied for non-admin account');
        setLoading(false);
        return;
      }

      setUser(res.data.user);
      localStorage.setItem('token', res.data.token);
      setNotification('Login successful!');

      if (isAdminPortal || loggedInUser?.role === 'admin') {
        navigate('/admin');
      } else {
        navigate('/dashboard');
      }
    } catch (err) {
      setError('Invalid credentials');
      setNotification('Login failed');
    }
    setLoading(false);
  };

  return (
    <form onSubmit={handleSubmit} style={{ maxWidth: 360, margin: '60px auto', padding: 24, border: '1px solid #dbe4f0', borderRadius: 10, background: '#fff' }}>
      <h2 style={{ marginTop: 0 }}>{loginTitle}</h2>
      <p style={{ margin: '0 0 12px', color: '#475569' }}>
        {loginSubtitle}
      </p>
      <input type="email" placeholder="Email" value={email} onChange={e => setEmail(e.target.value)} required style={{ width: '100%', padding: 9, marginBottom: 10 }} />
      <input type="password" placeholder="Password" value={password} onChange={e => setPassword(e.target.value)} required style={{ width: '100%', padding: 9, marginBottom: 10 }} />
      <button type="submit" style={{ width: '100%', padding: '10px 12px', background: '#0f4d92', border: 'none', borderRadius: 8, color: '#fff', fontWeight: 700 }}>
        Login
      </button>
      <div style={{ marginTop: 12, fontSize: 14, display: 'flex', gap: 12, flexWrap: 'wrap' }}>
        {isAdminPortal ? (
          <Link to="/portal/alumni" style={{ color: '#1d4ed8', textDecoration: 'none', fontWeight: 700 }}>
            Switch to Alumni Portal
          </Link>
        ) : (
          <Link to="/portal/admin" style={{ color: '#1d4ed8', textDecoration: 'none', fontWeight: 700 }}>
            Switch to Admin Portal
          </Link>
        )}
        {!isMembershipPortal && (
          <Link to="/portal/membership" style={{ color: '#0f766e', textDecoration: 'none', fontWeight: 700 }}>
            Switch to Membership Portal
          </Link>
        )}
        {isMembershipPortal && (
          <Link to="/portal/alumni" style={{ color: '#1d4ed8', textDecoration: 'none', fontWeight: 700 }}>
            Switch to Alumni Portal
          </Link>
        )}
      </div>
    </form>
  );
};

export default Login;
