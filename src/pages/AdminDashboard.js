import React, { useEffect, useState } from 'react';
import axios from 'axios';
import UserTable from '../components/UserTable';
import EventManagementPanel from '../components/EventManagementPanel';
import ResourceApprovalPanel from '../components/ResourceApprovalPanel';
import ChartsPanel from '../components/ChartsPanel';

const AdminDashboard = () => {
  const [users, setUsers] = useState([]);
  const [events, setEvents] = useState([]);
  const [resources, setResources] = useState([]);
  const [stats, setStats] = useState([]);

  useEffect(() => {
    axios.get('/api/admin/users').then(res => setUsers(res.data));
    axios.get('/api/admin/events').then(res => setEvents(res.data));
    axios.get('/api/admin/resources').then(res => setResources(res.data));
    axios.get('/api/admin/analytics').then(res => {
      setStats([
        { name: 'Users', count: res.data.users },
        { name: 'Events', count: res.data.events },
        { name: 'Resources', count: res.data.resources },
        { name: 'Registrations', count: res.data.registrations }
      ]);
    });
  }, []);

  // Placeholder handlers for edit/delete
  const handleEdit = (item) => alert('Edit: ' + JSON.stringify(item));
  const handleDelete = (item) => alert('Delete: ' + JSON.stringify(item));

  return (
    <div style={{ maxWidth: 900, margin: '0 auto', padding: 24 }}>
      <h2>Admin Dashboard</h2>
      <ChartsPanel stats={stats} />
      <h3>Users</h3>
      <UserTable users={users} onEdit={handleEdit} onDelete={handleDelete} />
      <h3>Events</h3>
      <EventManagementPanel events={events} onEdit={handleEdit} onDelete={handleDelete} />
      <h3>Resources</h3>
      <ResourceApprovalPanel resources={resources} onEdit={handleEdit} onDelete={handleDelete} />
    </div>
  );
};

export default AdminDashboard;
