import React, { useEffect, useState } from 'react';
import axios from 'axios';
import EventCard from '../components/EventCard';
import CalendarView from '../components/CalendarView';
import EventDetailModal from '../components/EventDetailModal';

const Events = ({ user }) => {
  const [events, setEvents] = useState([]);
  const [selected, setSelected] = useState(null);
  const [modalOpen, setModalOpen] = useState(false);
  const [notification, setNotification] = useState('');

  useEffect(() => {
    axios.get('/api/events').then(res => setEvents(res.data));
  }, []);

  const handleRegister = async (event) => {
    try {
      await axios.post(`/api/events/${event._id}/register`);
      setNotification('Registration successful!');
      setTimeout(() => setNotification(''), 2000);
    } catch (err) {
      setNotification('Registration failed.');
      setTimeout(() => setNotification(''), 2000);
    }
  };

  const handleView = (event) => {
    setSelected(event);
    setModalOpen(true);
  };

  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Events</h2>
      {notification && <div style={{ background: '#d1e7dd', padding: 8, borderRadius: 4, marginBottom: 12 }}>{notification}</div>}
      <CalendarView events={events} onSelect={handleView} />
      <div style={{ marginTop: 24 }}>
        {events.map(event => (
          <EventCard key={event._id} event={event} onRegister={handleRegister} onView={handleView} />
        ))}
      </div>
      <EventDetailModal event={selected} open={modalOpen} onClose={() => setModalOpen(false)} />
    </div>
  );
};

export default Events;
