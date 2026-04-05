import React from 'react';

function AboutPortal() {
  return (
    <div style={{ maxWidth: 1100, margin: '0 auto', padding: '28px 16px' }}>
      <section style={{ borderRadius: 14, overflow: 'hidden', marginBottom: 18, boxShadow: '0 12px 30px rgba(15,23,42,0.12)' }}>
        <img src="/wamdevin-full/img/about.jpg" alt="About Wamdin" style={{ width: '100%', height: 280, objectFit: 'cover' }} />
      </section>

      <h1 style={{ marginTop: 0 }}>About WAMDIN</h1>
      <p style={{ lineHeight: 1.7, color: '#334155' }}>
        WAMDIN is a regional platform focused on management development, training, research, and institutional collaboration across Africa. This modern frontend now integrates legacy Wamdevin content and assets while keeping the alumni portal features available in one interface.
      </p>

      <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))' }}>
        <article style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
          <h3 style={{ marginTop: 0 }}>Mission</h3>
          <p style={{ marginBottom: 0 }}>Strengthen leadership and public service delivery through learning, research, and regional knowledge exchange.</p>
        </article>
        <article style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
          <h3 style={{ marginTop: 0 }}>Regional Reach</h3>
          <p style={{ marginBottom: 0 }}>Legacy visual assets and pages from partner institutions are preserved and now accessible directly from this frontend.</p>
        </article>
        <article style={{ border: '1px solid #e2e8f0', borderRadius: 10, padding: 14 }}>
          <h3 style={{ marginTop: 0 }}>Digital Upgrade</h3>
          <p style={{ marginBottom: 0 }}>Authentication, directory search, events, messaging, and resource access are integrated with a modern React user experience.</p>
        </article>
      </div>
    </div>
  );
}

export default AboutPortal;
