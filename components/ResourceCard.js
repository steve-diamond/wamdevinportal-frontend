import React from 'react';

const ResourceCard = ({ resource, onDownload, onPreview }) => (
  <div style={{ border: '1px solid #ccc', borderRadius: 8, padding: 16, marginBottom: 12 }}>
    <h3>{resource.title}</h3>
    <div>{resource.category}</div>
    <div>{resource.description}</div>
    <div style={{ marginTop: 8 }}>
      <button onClick={() => onPreview(resource)}>Preview</button>
      <button onClick={() => onDownload(resource)} style={{ marginLeft: 8 }}>Download</button>
    </div>
  </div>
);

export default ResourceCard;
