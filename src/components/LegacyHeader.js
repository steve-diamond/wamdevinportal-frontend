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
    <header className="legacy-header">
      <div className="legacy-header-inner">
        <Link to="/" className="legacy-brand" aria-label="WAMDEVIN Home">
          <img src="/wamdevin-full/assets/images/logo-white.png" alt="WAMDEVIN" className="legacy-brand-logo" />
        </Link>

        <nav className="legacy-nav" aria-label="Primary">
          {navLinks.map((link) => {
            const active = location.pathname === link.to;
            return (
              <Link
                key={link.to}
                to={link.to}
                className={`legacy-nav-link ${active ? 'is-active' : ''}`}
              >
                {link.label}
              </Link>
            );
          })}
        </nav>

        <div className="legacy-auth-actions">
          <Link to="/portal" className="legacy-btn legacy-btn-login">
            Login
          </Link>
          <Link to="/signup" className="legacy-btn legacy-btn-register">
            Register
          </Link>
        </div>
      </div>
    </header>
  );
}

export default LegacyHeader;
