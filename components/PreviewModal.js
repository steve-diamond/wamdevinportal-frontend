import React from 'react';

const PreviewModal = ({ open, url, onClose }) => {
  if (!open || !url) return null;
  return (
    <div style={{ position: 'fixed', top: 0, left: 0, width: '100vw', height: '100vh', background: 'rgba(0,0,0,0.3)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1000 }}>
      <div style={{ background: '#fff', padding: 24, borderRadius: 8, minWidth: 320 }}>
        <h2>Preview</h2>
        <iframe src={url} title="Preview" style={{ width: 400, height: 400, border: 'none' }} />
        <div style={{ marginTop: 16 }}>
          <button onClick={onClose}>Close</button>
        </div>
      </div>
    </div>
  );
};

export default PreviewModal;
