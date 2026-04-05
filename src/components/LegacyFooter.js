import React from 'react';
import { Link } from 'react-router-dom';

function LegacyFooter() {
  return (
    <footer style={{ background: '#0d203d', color: '#dbe6f3', borderTop: '1px solid rgba(148,163,184,0.3)', marginTop: 24 }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '24px 16px' }}>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: 16 }}>
          <div>
            <img src="/wamdevin-full/assets/images/logo-white.png" alt="WAMDEVIN" style={{ height: 36, width: 'auto', marginBottom: 8 }} />
            <p style={{ margin: 0, lineHeight: 1.6 }}>West African Management Development Institutes Network.</p>
          </div>

          <div>
            <h4 style={{ marginTop: 0, marginBottom: 10 }}>Quick Links</h4>
            <div style={{ display: 'grid', gap: 6 }}>
              <Link to="/about" style={{ color: '#dbe6f3', textDecoration: 'none' }}>About</Link>
              <Link to="/membership" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Membership</Link>
              <Link to="/partners" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Partners</Link>
              <Link to="/projects" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Projects</Link>
            </div>
          </div>

          <div>
            <h4 style={{ marginTop: 0, marginBottom: 10 }}>Services</h4>
            <div style={{ display: 'grid', gap: 6 }}>
              <Link to="/training" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Training</Link>
              <Link to="/research" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Research</Link>
              <Link to="/publication" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Publication</Link>
              <Link to="/consultancy" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Consultancy</Link>
            </div>
          </div>

          <div>
            <h4 style={{ marginTop: 0, marginBottom: 10 }}>Portal</h4>
            <div style={{ display: 'grid', gap: 6 }}>
              <Link to="/portal" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Login</Link>
              <Link to="/signup" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Register</Link>
              <Link to="/legacy-content" style={{ color: '#dbe6f3', textDecoration: 'none' }}>Legacy Content Hub</Link>
            </div>
          </div>
        </div>

        <div style={{ marginTop: 16, paddingTop: 12, borderTop: '1px solid rgba(148,163,184,0.3)', fontSize: 13 }}>
          © {new Date().getFullYear()} WAMDEVIN. All rights reserved.
        </div>
      </div>
    </footer>
  );
}

export default LegacyFooter;
