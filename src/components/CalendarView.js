import React from 'react';

const CalendarView = ({ events, onSelect }) => {
  // Simple list view for now; can be replaced with a calendar library
  return (
    <div>
      <h3>Upcoming Events</h3>
      {events.length ? events.map(event => (
        <div key={event._id} style={{ marginBottom: 8 }}>
          <span style={{ fontWeight: 'bold' }}>{new Date(event.startDate).toLocaleDateString()}</span> -
          <span style={{ marginLeft: 8 }}>{event.title}</span>
          <button style={{ marginLeft: 12 }} onClick={() => onSelect(event)}>View</button>
        </div>
      )) : <div>No events found.</div>}
    </div>
  );
};

export default CalendarView;
