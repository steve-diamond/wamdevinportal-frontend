import React from 'react';

const EventManagementPanel = ({ events, onEdit, onDelete }) => (
  <table style={{ width: '100%', borderCollapse: 'collapse' }}>
    <thead>
      <tr>
        <th>Title</th>
        <th>Start</th>
        <th>End</th>
        <th>Location</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      {events.map(event => (
        <tr key={event._id}>
          <td>{event.title}</td>
          <td>{new Date(event.startDate).toLocaleString()}</td>
          <td>{new Date(event.endDate).toLocaleString()}</td>
          <td>{event.location}</td>
          <td>
            <button onClick={() => onEdit(event)}>Edit</button>
            <button onClick={() => onDelete(event)} style={{ marginLeft: 8 }}>Delete</button>
          </td>
        </tr>
      ))}
    </tbody>
  </table>
);

export default EventManagementPanel;
