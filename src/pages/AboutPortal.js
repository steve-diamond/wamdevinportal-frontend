import React from 'react';

function AboutPortal() {
  return (
    <div style={{ maxWidth: 1180, margin: '0 auto', padding: '28px 16px 36px' }}>
      <section style={{ borderRadius: 14, overflow: 'hidden', marginBottom: 18, boxShadow: '0 12px 30px rgba(15,23,42,0.12)' }}>
        <img src="/wamdevin-full/img/about.jpg" alt="About WAMDEVIN" style={{ width: '100%', height: 300, objectFit: 'cover' }} />
      </section>

      <p style={{ margin: 0, color: '#0f4d92', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.07em', fontSize: 12 }}>
        West African Management Development Institutes Network
      </p>
      <h1 style={{ margin: '10px 0 12px' }}>About WAMDEVIN</h1>
      <p style={{ lineHeight: 1.75, color: '#334155', marginTop: 0, maxWidth: 930 }}>
        WAMDEVIN is a regional platform for management excellence and institutional transformation. Since its establishment, the network has supported member institutes and public sector organizations through practical training, policy-relevant research, consultancy support, and collaborative leadership development.
      </p>
      <p style={{ lineHeight: 1.75, color: '#334155', maxWidth: 930 }}>
        Our vision is to strengthen governance performance across West Africa by building capable institutions, ethical leadership systems, and resilient knowledge networks that deliver measurable development outcomes for citizens.
      </p>

      <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))', marginBottom: 14 }}>
        <article style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 14, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>Mission</h3>
          <p style={{ marginBottom: 0, lineHeight: 1.65 }}>
            Strengthen leadership and public service delivery through competency-driven training, evidence-based policy support, and regional institutional cooperation.
          </p>
        </article>
        <article style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 14, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>Vision</h3>
          <p style={{ marginBottom: 0, lineHeight: 1.65 }}>
            A West Africa where management institutions are trusted engines of reform, innovation, and inclusive socio-economic development.
          </p>
        </article>
        <article style={{ border: '1px solid #dbe4f0', borderRadius: 12, padding: 14, background: '#fff' }}>
          <h3 style={{ marginTop: 0 }}>Regional Reach</h3>
          <p style={{ marginBottom: 0, lineHeight: 1.65 }}>
            WAMDEVIN convenes management development institutes, public agencies, and strategic partners across multiple countries to exchange solutions and scale impact.
          </p>
        </article>
      </div>

      <section style={{ background: 'linear-gradient(90deg, rgba(15,77,146,0.08), rgba(244,197,24,0.14))', borderRadius: 12, padding: 16 }}>
        <h3 style={{ margin: '0 0 8px' }}>Strategic Priorities</h3>
        <ul style={{ margin: 0, paddingLeft: 20, color: '#334155', lineHeight: 1.7 }}>
          <li>Leadership and executive capability development for public institutions.</li>
          <li>Applied management research that informs governance reform.</li>
          <li>Institutional strengthening through advisory and technical support.</li>
          <li>Regional knowledge exchange platforms for policy and practice.</li>
          <li>Partnership development for sustainable capacity-building programs.</li>
        </ul>
      </section>

      <section style={{ marginTop: 14 }}>
        <p style={{ margin: 0, color: '#475569', lineHeight: 1.7 }}>
          WAMDEVIN remains committed to building institutions that are responsive, accountable, and future-ready through coordinated action, practical learning, and long-term collaboration.
        </p>
      </section>
    </div>
  );
}

export default AboutPortal;
