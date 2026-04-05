import React from 'react';
import { Link } from 'react-router-dom';
import { legacyContentRoot, wamdevinImages, wamdevinPages } from '../data/wamdevinCatalog';

const cardStyle = {
  background: '#ffffff',
  borderRadius: 12,
  boxShadow: '0 8px 22px rgba(15, 23, 42, 0.08)',
  padding: 16
};

function WamdevinContentHub() {
  return (
    <div style={{ minHeight: '100vh', padding: '24px 16px', background: 'linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%)' }}>
      <div style={{ maxWidth: 1200, margin: '0 auto' }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: 12, flexWrap: 'wrap', marginBottom: 18 }}>
          <h1 style={{ margin: 0 }}>Wamdevin Legacy Content Hub</h1>
          <Link to="/" style={{ textDecoration: 'none', padding: '10px 14px', background: '#0f172a', color: '#fff', borderRadius: 8 }}>
            Back to Portal Home
          </Link>
        </div>

        <p style={{ color: '#334155', lineHeight: 1.6, maxWidth: 900 }}>
          This page exposes migrated Wamdevin assets and page source files inside the frontend app. PHP files are archived as source content and can be opened directly from this interface.
        </p>

        <div style={{ ...cardStyle, marginBottom: 20 }}>
          <h2 style={{ marginTop: 0 }}>Primary Brand Banner</h2>
          <img
            src={`${legacyContentRoot}/img/header.jpg`}
            alt="Wamdevin header"
            style={{ width: '100%', maxHeight: 280, objectFit: 'cover', borderRadius: 10 }}
          />
        </div>

        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: 16 }}>
          <section style={cardStyle}>
            <h3 style={{ marginTop: 0 }}>Legacy PHP Content ({wamdevinPages.length})</h3>
            <div style={{ display: 'grid', gap: 8, maxHeight: 520, overflowY: 'auto', paddingRight: 6 }}>
              {wamdevinPages.map((page) => (
                <a
                  key={page}
                  href={`${legacyContentRoot}/${page}`}
                  target="_blank"
                  rel="noreferrer"
                  style={{ color: '#1d4ed8', textDecoration: 'none', fontWeight: 600 }}
                >
                  {page}
                </a>
              ))}
            </div>
          </section>

          <section style={cardStyle}>
            <h3 style={{ marginTop: 0 }}>Legacy Image Library ({wamdevinImages.length})</h3>
            <div style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))',
              gap: 10,
              maxHeight: 520,
              overflowY: 'auto',
              paddingRight: 6
            }}>
              {wamdevinImages.map((image) => (
                <a
                  key={image}
                  href={`${legacyContentRoot}/img/${image}`}
                  target="_blank"
                  rel="noreferrer"
                  style={{ textDecoration: 'none', color: '#0f172a' }}
                >
                  <div style={{ border: '1px solid #e2e8f0', borderRadius: 8, overflow: 'hidden', background: '#fff' }}>
                    <img
                      src={`${legacyContentRoot}/img/${image}`}
                      alt={image}
                      style={{ width: '100%', height: 100, objectFit: 'cover', display: 'block' }}
                    />
                    <div style={{ fontSize: 12, padding: '8px 6px', wordBreak: 'break-word' }}>{image}</div>
                  </div>
                </a>
              ))}
            </div>
          </section>
        </div>
      </div>
    </div>
  );
}

export default WamdevinContentHub;
