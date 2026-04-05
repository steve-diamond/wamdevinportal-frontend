import React, { useEffect, useState } from 'react';
import EventCard from '../components/EventCard';
import CalendarView from '../components/CalendarView';
import EventDetailModal from '../components/EventDetailModal';
import api from '../api';

const Events = ({ user }) => {
  const [events, setEvents] = useState([]);
  const [selected, setSelected] = useState(null);
  const [modalOpen, setModalOpen] = useState(false);
  const [notification, setNotification] = useState('');
  const [form, setForm] = useState({
    title: '',
    description: '',
    startDate: '',
    endDate: '',
    location: ''
  });

  const canCreateEvent = !!user && ['admin', 'faculty'].includes(user.role);

  useEffect(() => {
    api.get('/api/events').then(res => setEvents(res.data));
  }, []);

  const fetchEvents = async () => {
    const res = await api.get('/api/events');
    setEvents(res.data);
  };

  const handleRegister = async (event) => {
    try {
      await api.post(`/api/events/${event._id}/register`);
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

  const handleCreate = async (e) => {
    e.preventDefault();
    try {
      await api.post('/api/events', form);
      setNotification('Event created successfully!');
      setForm({ title: '', description: '', startDate: '', endDate: '', location: '' });
      await fetchEvents();
      setTimeout(() => setNotification(''), 2000);
    } catch (err) {
      setNotification('Event creation failed.');
      setTimeout(() => setNotification(''), 2000);
    }
  };

  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Events</h2>
      {notification && <div style={{ background: '#d1e7dd', padding: 8, borderRadius: 4, marginBottom: 12 }}>{notification}</div>}

      {canCreateEvent && (
        <form onSubmit={handleCreate} style={{ marginBottom: 20, display: 'grid', gap: 8 }}>
          <input
            placeholder="Event title"
            value={form.title}
            onChange={(e) => setForm((prev) => ({ ...prev, title: e.target.value }))}
            required
          />
          <textarea
            placeholder="Description"
            value={form.description}
            onChange={(e) => setForm((prev) => ({ ...prev, description: e.target.value }))}
          />
          <input
            type="datetime-local"
            value={form.startDate}
            onChange={(e) => setForm((prev) => ({ ...prev, startDate: e.target.value }))}
          />
          <input
            type="datetime-local"
            value={form.endDate}
            onChange={(e) => setForm((prev) => ({ ...prev, endDate: e.target.value }))}
          />
          <input
            placeholder="Location"
            value={form.location}
            onChange={(e) => setForm((prev) => ({ ...prev, location: e.target.value }))}
          />
          <button type="submit">Create Event</button>
        </form>
      )}

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
