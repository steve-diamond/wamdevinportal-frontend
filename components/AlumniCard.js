import React from 'react';

const AlumniCard = ({ alumni, onConnect, onMessage }) => (
  <div style={{ border: '1px solid #ccc', borderRadius: 8, padding: 16, marginBottom: 12 }}>
    <div style={{ display: 'flex', alignItems: 'center', gap: 16 }}>
      <img
        src={alumni.profilePicture || 'https://via.placeholder.com/64'}
        alt={alumni.fullName}
        style={{ width: 64, height: 64, borderRadius: '50%' }}
      />
      <div style={{ flex: 1 }}>
        <h3 style={{ margin: 0 }}>{alumni.fullName}</h3>
        <div>{alumni.currentPosition} | {alumni.institution} ({alumni.graduationYear})</div>
        <div>{alumni.country}</div>
        <div>Skills: {alumni.skills?.join(', ')}</div>
        <div style={{ marginTop: 8 }}>
          <button onClick={() => onConnect(alumni)}>Connect</button>
          <button onClick={() => onMessage(alumni)} style={{ marginLeft: 8 }}>Message</button>
        </div>
      </div>
    </div>
  </div>
);

export default AlumniCard;
