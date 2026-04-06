import React from 'react';
import { Link } from 'react-router-dom';

function PortalAccess() {
  return (
    <div style={{ maxWidth: 980, margin: '0 auto', padding: '32px 16px 42px' }}>
      <p style={{ margin: 0, color: '#0f4d92', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.07em', fontSize: 12 }}>
        Portal Access
      </p>
      <h1 style={{ margin: '10px 0 12px' }}>Choose Your Portal</h1>
      <p style={{ color: '#334155', lineHeight: 1.7, maxWidth: 760 }}>
        Access is available in two channels. Select Alumni Portal for members and registered users, or Admin Portal for platform administrators.
      </p>

      <section style={{ display: 'grid', gap: 14, gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', marginTop: 18 }}>
        <article style={{ border: '1px solid #dbe4f0', borderRadius: 14, background: '#fff', padding: 18, boxShadow: '0 8px 24px rgba(15, 23, 42, 0.06)' }}>
          <h2 style={{ margin: '0 0 8px', fontSize: 22 }}>Alumni Portal</h2>
          <p style={{ margin: '0 0 14px', color: '#475569', lineHeight: 1.65 }}>
            For alumni, members, and program participants to access directory, events, resources, and messaging.
          </p>
          <Link
            to="/portal/alumni"
            style={{
              display: 'inline-block',
              textDecoration: 'none',
              background: '#0f4d92',
              color: '#fff',
              borderRadius: 9,
              padding: '9px 14px',
              fontWeight: 700
            }}
          >
            Enter Alumni Portal
          </Link>
        </article>

        <article style={{ border: '1px solid #dbe4f0', borderRadius: 14, background: '#fff', padding: 18, boxShadow: '0 8px 24px rgba(15, 23, 42, 0.06)' }}>
          <h2 style={{ margin: '0 0 8px', fontSize: 22 }}>Admin Portal</h2>
          <p style={{ margin: '0 0 14px', color: '#475569', lineHeight: 1.65 }}>
            For authorized administrators to manage users, events, resources, and analytics.
          </p>
          <Link
            to="/portal/admin"
            style={{
              display: 'inline-block',
              textDecoration: 'none',
              background: '#0b3b6e',
              color: '#fff',
              borderRadius: 9,
              padding: '9px 14px',
              fontWeight: 700
            }}
          >
            Enter Admin Portal
          </Link>
        </article>
      </section>

      <section
        style={{
          marginTop: 18,
          border: '1px solid #dbe4f0',
          borderRadius: 12,
          padding: 16,
          background: '#f8fbff'
        }}
      >
        <h3 style={{ margin: '0 0 8px' }}>Admin Login Details</h3>
        <ul style={{ margin: 0, paddingLeft: 20, color: '#334155', lineHeight: 1.7 }}>
          <li>Admin login URL: /portal/admin</li>
          <li>Access is restricted to users with role set to admin.</li>
          <li>Non-admin users are blocked from admin login and admin dashboard access.</li>
          <li>After successful admin login, you are redirected to /admin.</li>
          <li>Use assigned administrator credentials from your system administrator.</li>
        </ul>
      </section>
    </div>
  );
}

export default PortalAccess;
