import React from 'react';
import { Link } from 'react-router-dom';

function ContactPortal() {
  return (
    <div style={{ maxWidth: 980, margin: '0 auto', padding: '28px 16px' }}>
      <h1>Contact</h1>
      <p style={{ color: '#334155', lineHeight: 1.7 }}>
        Reach out for alumni support, partnerships, events, and training inquiries from this unified branded contact experience.
      </p>

      <div style={{ display: 'grid', gap: 14, gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))' }}>
        <div style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 16 }}>
          <h3 style={{ marginTop: 0 }}>General Inquiries</h3>
          <p style={{ margin: 0 }}>Email: info@wamdin.org</p>
          <p style={{ margin: '6px 0 0' }}>Phone: +234-000-000-0000</p>
        </div>

        <div style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 16 }}>
          <h3 style={{ marginTop: 0 }}>Other Pages</h3>
          <p style={{ margin: '0 0 8px' }}>Continue browsing without leaving the shared header and footer shell.</p>
          <Link to="/projects" style={{ color: '#1d4ed8', fontWeight: 600, textDecoration: 'none' }}>
            Go to Projects
          </Link>
        </div>
      </div>
    </div>
  );
}

export default ContactPortal;
