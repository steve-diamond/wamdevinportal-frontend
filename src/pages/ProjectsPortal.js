import React from 'react';
import { Link } from 'react-router-dom';

const projectLinks = [
  { to: '/projects', title: 'Projects', note: 'Explore active development initiatives.' },
  { to: '/research', title: 'Research', note: 'Access policy and institutional research content.' },
  { to: '/consultancy', title: 'Consultancy', note: 'View advisory and technical service areas.' },
  { to: '/services', title: 'Services', note: 'Browse WAMDEVIN training and support services.' },
  { to: '/publication', title: 'Publication', note: 'Read updates, papers, and publication highlights.' }
];

function ProjectsPortal() {
  return (
    <div style={{ maxWidth: 1100, margin: '0 auto', padding: '28px 16px' }}>
      <h1>Projects and Programs</h1>
      <p style={{ lineHeight: 1.7, color: '#334155' }}>
        Project, research, and service pages now run in a unified branded shell with the same shared header and footer.
      </p>

      <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))' }}>
        {projectLinks.map((link) => (
          <Link
            key={link.to}
            to={link.to}
            style={{
              textDecoration: 'none',
              color: '#0f172a',
              border: '1px solid #e2e8f0',
              borderRadius: 10,
              padding: 14,
              background: '#fff'
            }}
          >
            <h3 style={{ margin: '0 0 6px' }}>{link.title}</h3>
            <p style={{ margin: 0, color: '#475569' }}>{link.note}</p>
          </Link>
        ))}
      </div>
    </div>
  );
}

export default ProjectsPortal;
