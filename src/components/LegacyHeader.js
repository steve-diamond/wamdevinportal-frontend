import React from 'react';
import { Link, useLocation } from 'react-router-dom';

const navLinks = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/leadership', label: 'Leadership' },
  { to: '/services', label: 'Services' },
  { to: '/projects', label: 'Projects' },
  { to: '/gallery', label: 'Gallery' },
  { to: '/contact', label: 'Contact' },
  { to: '/portal', label: 'Portal' }
];

function LegacyHeader() {
  const location = useLocation();

  return (
    <header style={{ position: 'sticky', top: 0, zIndex: 1000, background: 'rgba(14,32,61,0.96)', borderBottom: '1px solid rgba(148,163,184,0.25)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '10px 14px', display: 'flex', alignItems: 'center', gap: 14, flexWrap: 'wrap' }}>
        <Link to="/" style={{ display: 'inline-flex', alignItems: 'center', textDecoration: 'none' }}>
          <img src="/wamdevin-full/assets/images/logo-white.png" alt="WAMDEVIN" style={{ height: 38, width: 'auto' }} />
        </Link>

        <nav style={{ display: 'flex', gap: 8, flexWrap: 'wrap' }}>
          {navLinks.map((link) => {
            const active = location.pathname === link.to;
            return (
              <Link
                key={link.to}
                to={link.to}
                style={{
                  textDecoration: 'none',
                  color: active ? '#0f172a' : '#e2e8f0',
                  background: active ? '#f4c518' : 'transparent',
                  border: active ? '1px solid #f4c518' : '1px solid rgba(148,163,184,0.45)',
                  borderRadius: 8,
                  padding: '7px 11px',
                  fontWeight: 600,
                  fontSize: 14
                }}
              >
                {link.label}
              </Link>
            );
          })}
        </nav>

        <div style={{ marginLeft: 'auto', display: 'flex', gap: 8 }}>
          <Link to="/portal" style={{ textDecoration: 'none', color: '#fff', background: '#1766a2', borderRadius: 8, padding: '7px 11px', fontWeight: 600 }}>
            Login
          </Link>
          <Link to="/signup" style={{ textDecoration: 'none', color: '#0f172a', background: '#f4c518', borderRadius: 8, padding: '7px 11px', fontWeight: 700 }}>
            Register
          </Link>
        </div>
      </div>
    </header>
  );
}

export default LegacyHeader;
