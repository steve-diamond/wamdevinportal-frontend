import React, { useEffect, useRef } from 'react';

const ChatWindow = ({ messages, userId }) => {
  const ref = useRef();
  useEffect(() => {
    if (ref.current) ref.current.scrollTop = ref.current.scrollHeight;
  }, [messages]);
  return (
    <div ref={ref} style={{ flex: 1, overflowY: 'auto', padding: 16, background: '#fafafa', minHeight: 300 }}>
      {messages.map(msg => (
        <div key={msg._id} style={{ marginBottom: 10, textAlign: msg.senderId === userId ? 'right' : 'left' }}>
          <div style={{ display: 'inline-block', background: msg.senderId === userId ? '#d1e7dd' : '#e2e3e5', borderRadius: 8, padding: 8 }}>
            {msg.content}
            {msg.status === 'unread' && <span style={{ color: 'red', marginLeft: 6 }}>•</span>}
          </div>
          <div style={{ fontSize: 10, color: '#888' }}>{new Date(msg.createdAt).toLocaleTimeString()}</div>
        </div>
      ))}
    </div>
  );
};

export default ChatWindow;
