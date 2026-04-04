import React from 'react';

const EventCard = ({ event, onRegister, onView }) => (
  <div style={{ border: '1px solid #ccc', borderRadius: 8, padding: 16, marginBottom: 12 }}>
    <h3>{event.title}</h3>
    <div>{event.startDate && new Date(event.startDate).toLocaleString()} - {event.endDate && new Date(event.endDate).toLocaleString()}</div>
    <div>{event.location}</div>
    <div>{event.description}</div>
    <div style={{ marginTop: 8 }}>
      <button onClick={() => onView(event)}>Details</button>
      <button onClick={() => onRegister(event)} style={{ marginLeft: 8 }}>Register</button>
    </div>
  </div>
);

export default EventCard;
