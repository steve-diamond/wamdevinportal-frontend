import React, { useEffect, useState, useRef } from 'react';
import io from 'socket.io-client';
import ChatList from '../components/ChatList';
import GroupList from '../components/GroupList';
import ChatWindow from '../components/ChatWindow';
import MessageInput from '../components/MessageInput';
import api from '../api';

const Messaging = ({ user }) => {
  const [chats, setChats] = useState([]);
  const [groups, setGroups] = useState([]);
  const [selectedChat, setSelectedChat] = useState(null);
  const [messages, setMessages] = useState([]);
  const [isGroup, setIsGroup] = useState(false);
  const socketRef = useRef();

  useEffect(() => {
    if (!user) return;
    socketRef.current = io(process.env.REACT_APP_API_URL || window.location.origin, {
      auth: { token: localStorage.getItem('token') }
    });
    socketRef.current.on('receive_message', msg => {
      setMessages(prev => [...prev, msg]);
      // Optionally: show notification
    });
    return () => socketRef.current.disconnect();
  }, [user]);

  useEffect(() => {
    if (!user) return;
    // Fetch chat list (users with whom user has messages)
    api.get('/api/users/search').then(res => setChats(res.data.users.filter(u => u._id !== user._id)));
    api.get('/api/groups').then(res => setGroups(res.data));
  }, [user]);

  const loadMessages = (chat, group = false) => {
    setSelectedChat(chat);
    setIsGroup(group);
    api.get(`/api/messages/${chat._id}?type=${group ? 'group' : 'user'}`)
      .then(res => setMessages(res.data));
  };

  const handleSend = (content) => {
    if (!selectedChat) return;
    socketRef.current.emit('send_message', {
      receiverId: selectedChat._id,
      content,
      group: isGroup
    });
  };

  return (
    <div style={{ display: 'flex', height: 500, border: '1px solid #ccc', borderRadius: 8 }}>
      <div>
        <ChatList chats={chats} onSelect={c => loadMessages(c, false)} selectedId={isGroup ? null : selectedChat?._id} />
        <GroupList groups={groups} onSelect={g => loadMessages(g, true)} selectedId={isGroup ? selectedChat?._id : null} />
      </div>
      <div style={{ flex: 1, display: 'flex', flexDirection: 'column' }}>
        <ChatWindow messages={messages} userId={user?._id} />
        <MessageInput onSend={handleSend} />
      </div>
    </div>
  );
};

export default Messaging;
