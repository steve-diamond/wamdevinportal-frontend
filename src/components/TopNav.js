import React from 'react';
import { Link, useLocation } from 'react-router-dom';

const links = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/leadership', label: 'Leadership' },
  { to: '/services', label: 'Services' },
  { to: '/projects', label: 'Projects' },
  { to: '/gallery', label: 'Gallery' },
  { to: '/contact-modern', label: 'Contact' },
  { to: '/portal', label: 'Portal' },
  { to: '/legacy-content', label: 'Legacy Content' },
  { to: '/signup', label: 'Register' }
];

function TopNav() {
  const location = useLocation();

  return (
    <header style={{ position: 'sticky', top: 0, zIndex: 1000, backdropFilter: 'blur(6px)', background: 'rgba(15, 23, 42, 0.93)', borderBottom: '1px solid rgba(148,163,184,0.2)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto', padding: '10px 14px', display: 'flex', alignItems: 'center', gap: 12, flexWrap: 'wrap' }}>
        <img src="/wamdevin-full/assets/images/logo.png" alt="Wamdin logo" style={{ width: 44, height: 44, objectFit: 'contain', borderRadius: 8, background: '#fff', padding: 2 }} />
        <div style={{ color: '#e2e8f0', fontWeight: 800, marginRight: 8, letterSpacing: 0.3 }}>WAMDIN Portal</div>
        <nav style={{ display: 'flex', gap: 8, flexWrap: 'wrap' }}>
          {links.map((link) => {
            const active = location.pathname === link.to;
            return (
              <Link
                key={link.to}
                to={link.to}
                style={{
                  textDecoration: 'none',
                  color: active ? '#0f172a' : '#e2e8f0',
                  background: active ? '#facc15' : 'transparent',
                  border: active ? '1px solid #facc15' : '1px solid rgba(148,163,184,0.4)',
                  padding: '7px 11px',
                  borderRadius: 8,
                  fontSize: 14,
                  fontWeight: 600
                }}
              >
                {link.label}
              </Link>
            );
          })}
        </nav>
      </div>
    </header>
  );
}

export default TopNav;
