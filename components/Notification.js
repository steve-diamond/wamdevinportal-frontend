import React from 'react';
import useStore from '../store/useStore';

const Notification = () => {
  const { notification, setNotification } = useStore();
  if (!notification) return null;
  return (
    <div style={{ position: 'fixed', top: 20, right: 20, background: '#d1e7dd', padding: 12, borderRadius: 6, zIndex: 1000 }}>
      {notification}
      <button style={{ marginLeft: 12 }} onClick={() => setNotification('')}>x</button>
    </div>
  );
};

export default Notification;
