import React from 'react';
import useStore from '../store/useStore';

const Profile = () => {
  const { user } = useStore();
  if (!user) return null;
  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Profile</h2>
      <div><b>Name:</b> {user.fullName}</div>
      <div><b>Email:</b> {user.email}</div>
      <div><b>Role:</b> {user.role}</div>
      {/* Add more profile fields and edit functionality as needed */}
    </div>
  );
};

export default Profile;
