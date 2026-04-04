import React from 'react';

const FilterPanel = ({ filters, onChange }) => (
  <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap', margin: '12px 0' }}>
    <input
      type="text"
      placeholder="Country"
      value={filters.country || ''}
      onChange={e => onChange({ ...filters, country: e.target.value })}
    />
    <input
      type="text"
      placeholder="Institution"
      value={filters.institution || ''}
      onChange={e => onChange({ ...filters, institution: e.target.value })}
    />
    <input
      type="number"
      placeholder="Graduation Year"
      value={filters.graduationYear || ''}
      onChange={e => onChange({ ...filters, graduationYear: e.target.value })}
    />
    <input
      type="text"
      placeholder="Skills (comma separated)"
      value={filters.skills || ''}
      onChange={e => onChange({ ...filters, skills: e.target.value })}
    />
  </div>
);

export default FilterPanel;
