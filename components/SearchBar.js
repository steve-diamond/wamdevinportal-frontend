import React from 'react';

const SearchBar = ({ value, onChange, onSearch }) => (
  <div style={{ display: 'flex', gap: '8px' }}>
    <input
      type="text"
      placeholder="Search by name, skill, etc."
      value={value}
      onChange={e => onChange(e.target.value)}
      style={{ flex: 1 }}
    />
    <button onClick={onSearch}>Search</button>
  </div>
);

export default SearchBar;
