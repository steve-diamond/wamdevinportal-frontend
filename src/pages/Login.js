import React, { useState, useEffect, useRef } from 'react';
import useStore from '../store/useStore';
import { useNavigate, useSearchParams } from 'react-router-dom';
import api from '../api';
import '../styles/dashboard.css';

const ROLE_TABS = [
  { key: 'alumni', label: '🎓 Alumni' },
  { key: 'membership', label: '🏛️ Membership' },
  { key: 'admin', label: '⚙️ Admin' },
];

const ROLE_SUBTITLES = {
  alumni: 'Sign in to access your alumni dashboard and services.',
  membership: 'For institutional focal persons and membership representatives.',
  admin: 'Authorized administrators only. All access is logged.',
};

export default function Login({ portalRole = 'alumni' }) {
  const [activeRole, setActiveRole] = useState(portalRole);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [otpCode, setOtpCode] = useState('');
  const [mfaStage, setMfaStage] = useState(false); // true after 1st factor
  const [localError, setLocalError] = useState('');
  const [submitting, setSubmitting] = useState(false);

  const { setUser, setLoading, pendingMfa, mfaTempToken, setPendingMfa, clearMfa, addToast } = useStore();
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const emailRef = useRef(null);
  const otpRef = useRef(null);

  // Keep local mfaStage in sync with store
  useEffect(() => {
    setMfaStage(pendingMfa);
    if (pendingMfa && otpRef.current) otpRef.current.focus();
  }, [pendingMfa]);

  // Sync role tab with prop
  useEffect(() => { setActiveRole(portalRole); }, [portalRole]);

  // Focus email on mount
  useEffect(() => { emailRef.current?.focus(); }, []);

  const handleRoleChange = (role) => {
    setActiveRole(role);
    setLocalError('');
    clearMfa();
    setMfaStage(false);
    setOtpCode('');
  };

  const handleFirstFactor = async (e) => {
    e.preventDefault();
    setLocalError('');
    setSubmitting(true);
    setLoading(true);
    try {
      const res = await api.post('/api/auth/login', { email, password });
      const loggedInUser = res.data.user;

      // Role guard
      if (activeRole === 'admin' && loggedInUser?.role !== 'admin') {
        setLocalError('Admin access only. Please use an admin account.');
        addToast('Access denied for non-admin account', 'error', 'Access Denied');
        setSubmitting(false);
        setLoading(false);
        return;
      }

      // If backend signals MFA required
      if (res.data.mfaRequired) {
        setPendingMfa(res.data.mfaTempToken || '');
        addToast('Enter your verification code to continue.', 'info', 'MFA Required');
        setSubmitting(false);
        setLoading(false);
        return;
      }

      // No MFA — direct login
      setUser(loggedInUser);
      localStorage.setItem('token', res.data.token);
      addToast('Welcome back, ' + (loggedInUser?.fullName || 'User') + '!', 'success', 'Signed in');
      navigate(loggedInUser?.role === 'admin' ? '/admin' : '/dashboard');
    } catch (err) {
      let msg;
      if (!err.response) {
        msg = 'Unable to connect to the server. Please try again in a moment.';
      } else {
        msg = err.response.data?.message || 'Invalid email or password.';
      }
      setLocalError(msg);
      addToast(msg, 'error', 'Login Failed');
    }
    setSubmitting(false);
    setLoading(false);
  };

  const handleMfaVerify = async (e) => {
    e.preventDefault();
    if (!otpCode.trim()) { setLocalError('Please enter the verification code.'); return; }
    setLocalError('');
    setSubmitting(true);
    setLoading(true);
    try {
      const res = await api.post('/api/auth/mfa/verify', {
        code: otpCode.trim(),
        tempToken: mfaTempToken,
      });
      setUser(res.data.user);
      localStorage.setItem('token', res.data.token);
      addToast('Welcome back, ' + (res.data.user?.fullName || 'User') + '!', 'success', 'Signed in');
      navigate(res.data.user?.role === 'admin' ? '/admin' : '/dashboard');
    } catch (err) {
      setLocalError('Invalid or expired verification code.');
      addToast('Invalid verification code.', 'error', 'MFA Failed');
    }
    setSubmitting(false);
    setLoading(false);
  };

  return (
    <div className="login-page" role="main">
      <div className="login-panel">
        <div className="login-card">
          {/* Brand */}
          <div className="login-logo">
            <img
              src="/wamdevin-full/assets/images/logo.png"
              alt="WAMDIN logo"
              onError={e => { e.target.style.display = 'none'; }}
            />
            <div className="login-logo-text">WAMDIN Portal</div>
          </div>

          {/* Role Tabs */}
          <div className="login-role-tabs" role="tablist" aria-label="Select portal">
            {ROLE_TABS.map(tab => (
              <button
                key={tab.key}
                role="tab"
                aria-selected={activeRole === tab.key}
                aria-controls={`panel-${tab.key}`}
                className={`login-role-tab${activeRole === tab.key ? ' active' : ''}`}
                onClick={() => handleRoleChange(tab.key)}
                disabled={mfaStage}
              >
                {tab.label}
              </button>
            ))}
          </div>

          <p style={{ fontSize: 13, color: 'var(--text-secondary)', marginBottom: 20, lineHeight: 1.5 }}>
            {ROLE_SUBTITLES[activeRole]}
          </p>

          {/* Error */}
          {localError && (
            <div
              role="alert"
              aria-live="assertive"
              style={{
                background: '#fee2e2', color: '#b91c1c', padding: '10px 14px',
                borderRadius: 8, fontSize: 13, marginBottom: 14,
                border: '1px solid #fca5a5',
              }}
            >
              ⚠ {localError}
            </div>
          )}

          {!mfaStage ? (
            /* ── First Factor ── */
            <form onSubmit={handleFirstFactor} noValidate aria-label="Login form">
              <div className="form-group">
                <label className="form-label" htmlFor="login-email">Email address</label>
                <input
                  id="login-email"
                  ref={emailRef}
                  type="email"
                  className="form-input"
                  placeholder="you@example.com"
                  value={email}
                  onChange={e => setEmail(e.target.value)}
                  required
                  autoComplete="username"
                  aria-required="true"
                  aria-describedby={localError ? 'login-error' : undefined}
                />
              </div>

              <div className="form-group" style={{ position: 'relative' }}>
                <label className="form-label" htmlFor="login-password">Password</label>
                <input
                  id="login-password"
                  type={showPassword ? 'text' : 'password'}
                  className="form-input"
                  placeholder="••••••••"
                  value={password}
                  onChange={e => setPassword(e.target.value)}
                  required
                  autoComplete="current-password"
                  aria-required="true"
                  style={{ paddingRight: 44 }}
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(s => !s)}
                  aria-label={showPassword ? 'Hide password' : 'Show password'}
                  style={{
                    position: 'absolute', right: 10, bottom: 9,
                    background: 'none', border: 'none', cursor: 'pointer',
                    color: 'var(--text-muted)', fontSize: 18,
                  }}
                >
                  {showPassword ? '🙈' : '👁️'}
                </button>
              </div>

              <button
                type="submit"
                className="btn btn-primary"
                style={{ width: '100%', justifyContent: 'center', padding: '11px', marginTop: 4, fontSize: 14 }}
                disabled={submitting}
                aria-busy={submitting}
              >
                {submitting ? 'Signing in…' : 'Sign In'}
              </button>

              <div style={{ marginTop: 16, fontSize: 13, color: 'var(--text-secondary)', textAlign: 'center' }}>
                Don't have an account?{' '}
                <a href="/signup" style={{ color: 'var(--primary)', fontWeight: 600, textDecoration: 'none' }}>
                  Register
                </a>
              </div>
            </form>
          ) : (
            /* ── MFA Step ── */
            <form onSubmit={handleMfaVerify} aria-label="Two-factor verification form">
              <div className="mfa-section">
                <div style={{ fontWeight: 700, fontSize: 14, marginBottom: 8, color: 'var(--text-primary)' }}>
                  🔐 Two-Factor Verification
                </div>
                <div className="form-group" style={{ marginBottom: 8 }}>
                  <label className="form-label" htmlFor="otp-code">Verification code</label>
                  <input
                    id="otp-code"
                    ref={otpRef}
                    type="text"
                    inputMode="numeric"
                    pattern="[0-9]*"
                    maxLength={8}
                    className="form-input"
                    placeholder="123456"
                    value={otpCode}
                    onChange={e => setOtpCode(e.target.value.replace(/\D/g, ''))}
                    autoComplete="one-time-code"
                    aria-required="true"
                    style={{ letterSpacing: '0.2em', fontSize: 20, textAlign: 'center' }}
                  />
                  <p className="mfa-hint">
                    Enter the 6-digit code from your authenticator app or the code sent to your email.
                  </p>
                </div>
              </div>

              <div style={{ display: 'flex', gap: 8, marginTop: 16 }}>
                <button
                  type="button"
                  className="btn btn-secondary"
                  style={{ flex: 1 }}
                  onClick={() => { clearMfa(); setMfaStage(false); setOtpCode(''); }}
                >
                  ← Back
                </button>
                <button
                  type="submit"
                  className="btn btn-primary"
                  style={{ flex: 2, justifyContent: 'center' }}
                  disabled={submitting || otpCode.length < 4}
                  aria-busy={submitting}
                >
                  {submitting ? 'Verifying…' : 'Verify & Sign In'}
                </button>
              </div>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}
