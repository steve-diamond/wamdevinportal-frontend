import React from 'react';
import useStore from '../store/useStore';

const Dashboard = () => {
  const { user } = useStore();
  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Welcome, {user?.fullName || 'User'}!</h2>
      <p>This is your dashboard.</p>
    </div>
  );
};

export default Dashboard;
