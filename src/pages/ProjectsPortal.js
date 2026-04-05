import React from 'react';

const legacyProjectPages = [
  'projects.php',
  'research.php',
  'consultancy.php',
  'service.php',
  'publication.php'
];

function ProjectsPortal() {
  return (
    <div style={{ maxWidth: 1100, margin: '0 auto', padding: '28px 16px' }}>
      <h1>Projects and Programs</h1>
      <p style={{ lineHeight: 1.7, color: '#334155' }}>
        This section connects the modern frontend to legacy Wamdevin project and research content while preserving links to original archive pages.
      </p>

      <div style={{ display: 'grid', gap: 12, gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))' }}>
        {legacyProjectPages.map((page) => (
          <a
            key={page}
            href={`/wamdevin-full/${page}`}
            target="_blank"
            rel="noreferrer"
            style={{
              textDecoration: 'none',
              color: '#0f172a',
              border: '1px solid #e2e8f0',
              borderRadius: 10,
              padding: 14,
              background: '#fff'
            }}
          >
            <h3 style={{ margin: '0 0 6px' }}>{page.replace('.php', '').replace('-', ' ')}</h3>
            <p style={{ margin: 0, color: '#475569' }}>Open legacy content archive</p>
          </a>
        ))}
      </div>
    </div>
  );
}

export default ProjectsPortal;
