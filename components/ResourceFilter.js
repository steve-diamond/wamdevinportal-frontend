import React from 'react';

const ResourceFilter = ({ category, onChange }) => (
  <div style={{ margin: '12px 0' }}>
    <select value={category} onChange={e => onChange(e.target.value)}>
      <option value="">All Categories</option>
      <option value="research">Research</option>
      <option value="training">Training</option>
      <option value="policy">Policy</option>
    </select>
  </div>
);

export default ResourceFilter;
