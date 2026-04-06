import React from 'react';
import { Link } from 'react-router-dom';

function LegacyFooter() {
  return (
    <footer className="legacy-footer">
      <div className="legacy-footer-inner">
        <div className="legacy-footer-grid">
          <div>
            <img src="/wamdevin-full/assets/images/logo-white.png" alt="WAMDEVIN" className="legacy-footer-logo" />
            <p className="legacy-footer-copy">West African Management Development Institutes Network.</p>
          </div>

          <div>
            <h4 className="legacy-footer-title">Quick Links</h4>
            <div className="legacy-footer-links">
              <Link to="/about">About</Link>
              <Link to="/membership">Membership</Link>
              <Link to="/partners">Partners</Link>
              <Link to="/projects">Projects</Link>
            </div>
          </div>

          <div>
            <h4 className="legacy-footer-title">Services</h4>
            <div className="legacy-footer-links">
              <Link to="/training">Training</Link>
              <Link to="/research">Research</Link>
              <Link to="/publication">Publication</Link>
              <Link to="/consultancy">Consultancy</Link>
            </div>
          </div>

          <div>
            <h4 className="legacy-footer-title">Portal</h4>
            <div className="legacy-footer-links">
              <Link to="/portal">Login</Link>
              <Link to="/signup">Register</Link>
              <Link to="/contact">Contact Desk</Link>
            </div>
          </div>
        </div>

        <div className="legacy-footer-bottom">
          © {new Date().getFullYear()} WAMDEVIN. All rights reserved.
        </div>
      </div>
    </footer>
  );
}

export default LegacyFooter;
