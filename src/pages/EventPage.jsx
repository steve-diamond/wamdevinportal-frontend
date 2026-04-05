import React, { useEffect, useState } from 'react';
import axios from 'axios';

function EventPage() {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    fetchEvents();
  }, []);

  const fetchEvents = async () => {
    const res = await axios.get('http://localhost:5000/api/events', {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    });
    setEvents(res.data);
  };

  const register = async (id) => {
    await axios.post(`http://localhost:5000/api/events/${id}/register`, {}, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    });
    alert('Registered!');
  };

  return (
    <div className="p-6">
      <h2 className="text-xl mb-4">Events</h2>

      {events.map((event) => (
        <div key={event._id} className="border p-4 mb-4">
          <h3 className="font-bold">{event.title}</h3>
          <p>{event.description}</p>
          <button onClick={() => register(event._id)} className="bg-green-600 text-white px-3 py-1 mt-2">
            Register
          </button>
        </div>
      ))}
    </div>
  );
}

export default EventPage;
