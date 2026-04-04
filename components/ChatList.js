import React from 'react';

const ChatList = ({ chats, onSelect, selectedId }) => (
  <div style={{ width: 220, borderRight: '1px solid #ddd', height: '100%', overflowY: 'auto' }}>
    <h4 style={{ margin: 12 }}>Chats</h4>
    {chats.map(chat => (
      <div
        key={chat._id}
        onClick={() => onSelect(chat)}
        style={{
          padding: 12,
          background: selectedId === chat._id ? '#f0f0f0' : 'transparent',
          cursor: 'pointer',
          borderBottom: '1px solid #eee',
          fontWeight: chat.unread ? 'bold' : 'normal'
        }}
      >
        {chat.name || chat.fullName}
        {chat.unread && <span style={{ color: 'red', marginLeft: 8 }}>&#9679;</span>}
      </div>
    ))}
  </div>
);

export default ChatList;
