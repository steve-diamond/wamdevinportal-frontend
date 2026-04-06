import React from 'react';
import { Link } from 'react-router-dom';

const secretariatAddress = 'WAMDEVIN Secretariat, Accra, Ghana';
const mapEmbedSrc = 'https://www.google.com/maps?q=' + encodeURIComponent(secretariatAddress) + '&output=embed';
const mapDirectionLink = 'https://www.google.com/maps/dir/?api=1&destination=' + encodeURIComponent(secretariatAddress);

function ContactPortal() {
  return (
    <div style={{ maxWidth: 1100, margin: '0 auto', padding: '28px 16px 36px' }}>
      <p style={{ margin: 0, color: '#0f4d92', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.07em', fontSize: 12 }}>
        Secretariat and Partnership Desk
      </p>
      <h1 style={{ margin: '10px 0 12px' }}>Contact WAMDEVIN</h1>
      <p style={{ color: '#334155', lineHeight: 1.75, marginTop: 0, maxWidth: 860 }}>
        Contact us for institutional membership, leadership programs, project collaboration, consultancy requests, and regional partnership opportunities.
      </p>

      <div style={{ display: 'grid', gap: 14, gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', marginBottom: 14 }}>
        <div style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 16, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>General Inquiries</h3>
          <p style={{ margin: '0 0 6px' }}><strong>Email:</strong> info@wamdevin.org</p>
          <p style={{ margin: '0 0 6px' }}><strong>Phone:</strong> +233 (0) 123 456 789</p>
          <p style={{ margin: 0 }}><strong>Hours:</strong> Mon-Fri, 9:00 AM - 5:00 PM (GMT)</p>
        </div>

        <div style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 16, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>Partnership and Programs</h3>
          <p style={{ margin: '0 0 6px' }}><strong>Email:</strong> partnerships@wamdevin.org</p>
          <p style={{ margin: '0 0 6px' }}><strong>Programs:</strong> training@wamdevin.org</p>
          <p style={{ margin: 0 }}><strong>Consultancy:</strong> advisory@wamdevin.org</p>
        </div>

        <div style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 16, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>Secretariat Location</h3>
          <p style={{ margin: '0 0 6px' }}><strong>Address:</strong> WAMDEVIN Secretariat, Accra, Ghana</p>
          <p style={{ margin: '0 0 6px' }}><strong>Region:</strong> West Africa</p>
          <p style={{ margin: 0 }}><strong>Engagement:</strong> In-person and virtual collaboration sessions</p>
        </div>
      </div>

      <section style={{ border: '1px solid #dbe4f0', borderRadius: 12, overflow: 'hidden', background: '#fff', marginBottom: 14 }}>
        <div style={{ padding: 16, borderBottom: '1px solid #e2e8f0' }}>
          <h3 style={{ margin: '0 0 6px' }}>Directions to the Secretariat</h3>
          <p style={{ margin: 0, color: '#475569' }}>
            Use the map below to locate the office and open turn-by-turn Google directions.
          </p>
        </div>
        <iframe
          title="WAMDEVIN Secretariat Location"
          src={mapEmbedSrc}
          width="100%"
          height="320"
          style={{ border: 0, display: 'block' }}
          loading="lazy"
          referrerPolicy="no-referrer-when-downgrade"
          allowFullScreen
        />
        <div style={{ padding: 16, borderTop: '1px solid #e2e8f0' }}>
          <a
            href={mapDirectionLink}
            target="_blank"
            rel="noreferrer"
            style={{ color: '#0f4d92', fontWeight: 700, textDecoration: 'none' }}
          >
            Open Google Maps Directions
          </a>
        </div>
      </section>

      <section style={{ background: 'linear-gradient(90deg, rgba(15,77,146,0.08), rgba(244,197,24,0.14))', borderRadius: 12, padding: 16, marginBottom: 14 }}>
        <h3 style={{ margin: '0 0 8px' }}>Before You Contact Us</h3>
        <ul style={{ margin: 0, paddingLeft: 20, color: '#334155', lineHeight: 1.7 }}>
          <li>Include your institution name and country for faster routing.</li>
          <li>Specify your request category: training, research, consultancy, or partnership.</li>
          <li>For event support, include expected date, audience, and thematic focus.</li>
          <li>For collaboration requests, share intended outcomes and timeline.</li>
        </ul>
      </section>

      <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
        <Link to="/projects" style={{ color: '#1d4ed8', fontWeight: 700, textDecoration: 'none' }}>
          View Strategic Projects
        </Link>
        <span style={{ color: '#94a3b8' }}>|</span>
        <Link to="/services" style={{ color: '#1d4ed8', fontWeight: 700, textDecoration: 'none' }}>
          Explore Service Areas
        </Link>
      </div>
    </div>
  );
}

export default ContactPortal;
