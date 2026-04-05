import React from 'react';

const GroupList = ({ groups, onSelect, selectedId }) => (
  <div style={{ width: 220, borderRight: '1px solid #ddd', height: '100%', overflowY: 'auto' }}>
    <h4 style={{ margin: 12 }}>Groups</h4>
    {groups.map(group => (
      <div
        key={group._id}
        onClick={() => onSelect(group)}
        style={{
          padding: 12,
          background: selectedId === group._id ? '#f0f0f0' : 'transparent',
          cursor: 'pointer',
          borderBottom: '1px solid #eee'
        }}
      >
        {group.name}
      </div>
    ))}
  </div>
);

export default GroupList;
