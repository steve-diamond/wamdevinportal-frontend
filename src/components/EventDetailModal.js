import React from 'react';

const EventDetailModal = ({ event, open, onClose }) => {
  if (!open || !event) return null;
  return (
    <div style={{ position: 'fixed', top: 0, left: 0, width: '100vw', height: '100vh', background: 'rgba(0,0,0,0.3)', display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1000 }}>
      <div style={{ background: '#fff', padding: 24, borderRadius: 8, minWidth: 320 }}>
        <h2>{event.title}</h2>
        <div><b>When:</b> {event.startDate && new Date(event.startDate).toLocaleString()} - {event.endDate && new Date(event.endDate).toLocaleString()}</div>
        <div><b>Where:</b> {event.location}</div>
        <div><b>Description:</b> {event.description}</div>
        <div style={{ marginTop: 16 }}>
          <button onClick={onClose}>Close</button>
        </div>
      </div>
    </div>
  );
};

export default EventDetailModal;
