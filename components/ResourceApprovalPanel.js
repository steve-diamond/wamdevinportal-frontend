import React from 'react';

const ResourceApprovalPanel = ({ resources, onEdit, onDelete }) => (
  <table style={{ width: '100%', borderCollapse: 'collapse' }}>
    <thead>
      <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Uploader</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      {resources.map(resource => (
        <tr key={resource._id}>
          <td>{resource.title}</td>
          <td>{resource.category}</td>
          <td>{resource.uploadedBy?.fullName || '-'}</td>
          <td>
            <button onClick={() => onEdit(resource)}>Edit</button>
            <button onClick={() => onDelete(resource)} style={{ marginLeft: 8 }}>Delete</button>
          </td>
        </tr>
      ))}
    </tbody>
  </table>
);

export default ResourceApprovalPanel;
