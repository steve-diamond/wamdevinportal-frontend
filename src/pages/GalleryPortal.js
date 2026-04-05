import React from 'react';
import { legacyContentRoot, wamdevinImages } from '../data/wamdevinCatalog';

function GalleryPortal() {
  return (
    <div style={{ maxWidth: 1180, margin: '0 auto', padding: '28px 16px' }}>
      <h1>Legacy Gallery</h1>
      <p style={{ color: '#334155', lineHeight: 1.7 }}>
        Curated image library imported from the Wamdevin folder and available in the modern frontend.
      </p>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(180px, 1fr))', gap: 12 }}>
        {wamdevinImages.map((image) => (
          <a
            key={image}
            href={`${legacyContentRoot}/img/${image}`}
            target="_blank"
            rel="noreferrer"
            style={{ textDecoration: 'none', color: '#0f172a' }}
          >
            <div style={{ borderRadius: 10, overflow: 'hidden', border: '1px solid #e2e8f0', background: '#fff' }}>
              <img src={`${legacyContentRoot}/img/${image}`} alt={image} style={{ width: '100%', height: 130, objectFit: 'cover' }} />
              <div style={{ fontSize: 12, padding: 8, wordBreak: 'break-word' }}>{image}</div>
            </div>
          </a>
        ))}
      </div>
    </div>
  );
}

export default GalleryPortal;
