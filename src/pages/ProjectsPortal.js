import React from 'react';
import { Link } from 'react-router-dom';

const priorityProjects = [
  {
    title: 'Public Sector Leadership Acceleration Program',
    objective: 'Build high-performance leadership capacity in ministries, agencies, and public institutions across West Africa.',
    scope: 'Regional / Multi-country',
    timeline: '2026-2028',
    status: 'Active',
    deliverables: [
      'Executive leadership bootcamps for senior and mid-level officers',
      'Institutional mentoring framework for reform implementation',
      'Competency-based curriculum and leadership assessment toolkit'
    ],
    expectedImpact: 'Improved policy execution, accountability, and service delivery outcomes in participating institutions.'
  },
  {
    title: 'Regional Management Research and Knowledge Observatory',
    objective: 'Generate applied evidence that informs governance reform, administrative modernization, and development management policy.',
    scope: 'Regional research network',
    timeline: '2026-2027',
    status: 'Scaling',
    deliverables: [
      'Annual West Africa management performance report',
      'Cross-country case study repository and digital knowledge base',
      'Policy briefs for public sector decision-makers'
    ],
    expectedImpact: 'Better evidence-based planning and stronger institutional learning across member countries.'
  },
  {
    title: 'Institutional Digital Transformation Support Initiative',
    objective: 'Support member institutions to modernize core administrative processes, learning systems, and stakeholder service channels.',
    scope: 'Institution-level interventions',
    timeline: '2026-2029',
    status: 'Pilot + Rollout',
    deliverables: [
      'Digital service workflow mapping and redesign',
      'Change management and staff digital readiness training',
      'Implementation support for monitoring dashboards'
    ],
    expectedImpact: 'Higher operational efficiency, improved transparency, and faster service turnaround in target institutions.'
  }
];

const projectNavigation = [
  { to: '/research', title: 'Research Hub', note: 'Evidence, studies, and policy insight outputs.' },
  { to: '/consultancy', title: 'Consultancy Services', note: 'Advisory and implementation support services.' },
  { to: '/services', title: 'Program Services', note: 'Training, capability development, and technical support.' },
  { to: '/publication', title: 'Publications', note: 'Reports, briefs, and curated learning resources.' },
  { to: '/contact', title: 'Partnership Desk', note: 'Engage with WAMDEVIN for collaboration and project participation.' }
];

function ProjectsPortal() {
  return (
    <div style={{ maxWidth: 1180, margin: '0 auto', padding: '28px 16px 36px' }}>
      <section style={{ marginBottom: 20 }}>
        <p style={{ margin: 0, color: '#0f4d92', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.07em', fontSize: 12 }}>
          WAMDEVIN Project Portfolio
        </p>
        <h1 style={{ margin: '10px 0 12px' }}>Strategic Projects Aligned with Regional Transformation</h1>
        <p style={{ lineHeight: 1.75, color: '#334155', margin: 0, maxWidth: 920 }}>
          Our projects are designed to advance WAMDEVIN's vision: strengthening management excellence, institutional effectiveness, and regional cooperation for sustainable development in West Africa.
        </p>
      </section>

      <section style={{ display: 'grid', gap: 14, marginBottom: 22 }}>
        {priorityProjects.map((project) => (
          <article key={project.title} style={{ background: '#fff', border: '1px solid #dbe4f0', borderRadius: 14, padding: 16, boxShadow: '0 8px 24px rgba(15, 23, 42, 0.07)' }}>
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 12, flexWrap: 'wrap' }}>
              <h2 style={{ margin: 0, fontSize: 22 }}>{project.title}</h2>
              <span style={{ padding: '5px 11px', borderRadius: 999, fontWeight: 700, fontSize: 12, textTransform: 'uppercase', background: '#f4c518', color: '#0f172a' }}>
                {project.status}
              </span>
            </div>

            <p style={{ margin: '10px 0 12px', color: '#334155', lineHeight: 1.7 }}>{project.objective}</p>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(170px, 1fr))', gap: 8, marginBottom: 10 }}>
              <div style={{ background: '#f8fbff', border: '1px solid #e2e8f0', borderRadius: 10, padding: 10 }}>
                <strong>Scope</strong>
                <div style={{ color: '#475569' }}>{project.scope}</div>
              </div>
              <div style={{ background: '#f8fbff', border: '1px solid #e2e8f0', borderRadius: 10, padding: 10 }}>
                <strong>Timeline</strong>
                <div style={{ color: '#475569' }}>{project.timeline}</div>
              </div>
            </div>

            <div style={{ marginBottom: 10 }}>
              <h3 style={{ margin: '0 0 8px', fontSize: 17 }}>Key Deliverables</h3>
              <ul style={{ margin: 0, paddingLeft: 20, color: '#334155', lineHeight: 1.6 }}>
                {project.deliverables.map((deliverable) => (
                  <li key={deliverable}>{deliverable}</li>
                ))}
              </ul>
            </div>

            <div style={{ background: 'linear-gradient(90deg, rgba(15,77,146,0.08), rgba(244,197,24,0.16))', borderRadius: 10, padding: 12 }}>
              <strong>Expected Impact:</strong>
              <p style={{ margin: '6px 0 0', color: '#334155', lineHeight: 1.65 }}>{project.expectedImpact}</p>
            </div>
          </article>
        ))}
      </section>

      <section>
        <h2 style={{ margin: '0 0 10px', fontSize: 24 }}>Related Program Areas</h2>
        <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))' }}>
          {projectNavigation.map((link) => (
            <Link
              key={link.to}
              to={link.to}
              style={{
                textDecoration: 'none',
                color: '#0f172a',
                border: '1px solid #dbe4f0',
                borderRadius: 12,
                padding: 14,
                background: '#fff'
              }}
            >
              <h3 style={{ margin: '0 0 6px', fontSize: 18 }}>{link.title}</h3>
              <p style={{ margin: 0, color: '#475569', lineHeight: 1.6 }}>{link.note}</p>
            </Link>
          ))}
        </div>
      </section>
      <section style={{ marginTop: 16 }}>
        <p style={{ margin: 0, color: '#475569' }}>
          For project partnerships, sponsorship, or implementation collaboration, contact the WAMDEVIN Secretariat through the Partnership Desk.
        </p>
      </section>
    </div>
  );
}

export default ProjectsPortal;
