import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ResourceCard from '../components/ResourceCard';
import ResourceFilter from '../components/ResourceFilter';
import UploadModal from '../components/UploadModal';
import PreviewModal from '../components/PreviewModal';

const Resources = ({ user }) => {
  const [resources, setResources] = useState([]);
  const [category, setCategory] = useState('');
  const [uploadOpen, setUploadOpen] = useState(false);
  const [previewUrl, setPreviewUrl] = useState('');
  const [previewOpen, setPreviewOpen] = useState(false);
  const [notification, setNotification] = useState('');

  const fetchResources = async (cat = category) => {
    const res = await axios.get(`/api/resources?category=${cat}`);
    setResources(res.data);
  };

  useEffect(() => { fetchResources(); }, [category]);

  const handleUpload = async ({ title, description, category, file }) => {
    const token = localStorage.getItem('token');
    const formData = new FormData();
    formData.append('file', file);
    formData.append('title', title);
    formData.append('description', description);
    formData.append('category', category);
    try {
      await axios.post('/api/resources/upload', formData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      setNotification('Upload successful!');
      setUploadOpen(false);
      fetchResources();
      setTimeout(() => setNotification(''), 2000);
    } catch {
      setNotification('Upload failed.');
      setTimeout(() => setNotification(''), 2000);
    }
  };

  const handleDownload = async (resource) => {
    const res = await axios.get(`/api/resources/${resource._id}/download`);
    window.open(res.data.url, '_blank');
  };

  const handlePreview = async (resource) => {
    const res = await axios.get(`/api/resources/${resource._id}/download`);
    setPreviewUrl(res.data.url);
    setPreviewOpen(true);
  };

  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Knowledge Repository</h2>
      {notification && <div style={{ background: '#d1e7dd', padding: 8, borderRadius: 4, marginBottom: 12 }}>{notification}</div>}
      <ResourceFilter category={category} onChange={setCategory} />
      {user && ['alumni', 'faculty', 'admin'].includes(user.role) && (
        <button onClick={() => setUploadOpen(true)} style={{ marginBottom: 16 }}>Upload Resource</button>
      )}
      <div>
        {resources.map(resource => (
          <ResourceCard
            key={resource._id}
            resource={resource}
            onDownload={handleDownload}
            onPreview={handlePreview}
          />
        ))}
      </div>
      <UploadModal open={uploadOpen} onClose={() => setUploadOpen(false)} onUpload={handleUpload} />
      <PreviewModal open={previewOpen} url={previewUrl} onClose={() => setPreviewOpen(false)} />
    </div>
  );
};

export default Resources;
