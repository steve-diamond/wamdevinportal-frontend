import React, { useState } from 'react';

const UploadModal = ({ open, onClose, onUpload }) => {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [category, setCategory] = useState('research');
  const [file, setFile] = useState(null);

  if (!open) return null;

  return (
    <div style={{ position: 'fixed', top: 0, left: 0, width: '100vw', height: '100vh', background: 'rgba(0,0,0,0.3)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1000 }}>
      <form
        style={{ background: '#fff', padding: 24, borderRadius: 8, minWidth: 320 }}
        onSubmit={e => {
          e.preventDefault();
          if (file) onUpload({ title, description, category, file });
        }}
      >
        <h2>Upload Resource</h2>
        <input type="text" placeholder="Title" value={title} onChange={e => setTitle(e.target.value)} required />
        <textarea placeholder="Description" value={description} onChange={e => setDescription(e.target.value)} style={{ width: '100%', marginTop: 8 }} />
        <select value={category} onChange={e => setCategory(e.target.value)} style={{ marginTop: 8 }}>
          <option value="research">Research</option>
          <option value="training">Training</option>
          <option value="policy">Policy</option>
        </select>
        <input type="file" onChange={e => setFile(e.target.files[0])} style={{ marginTop: 8 }} required />
        <div style={{ marginTop: 16 }}>
          <button type="submit">Upload</button>
          <button type="button" onClick={onClose} style={{ marginLeft: 8 }}>Cancel</button>
        </div>
      </form>
    </div>
  );
};

export default UploadModal;
