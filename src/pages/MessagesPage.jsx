import React, { useEffect, useState } from 'react';
import { io } from 'socket.io-client';

const socket = io('http://localhost:5000');

function MessagesPage() {
  const [message, setMessage] = useState('');
  const [messages, setMessages] = useState([]);

  useEffect(() => {
    socket.on('receiveMessage', (data) => {
      setMessages((prev) => [...prev, data]);
    });
  }, []);

  const sendMessage = () => {
    socket.emit('sendMessage', { message });
    setMessage('');
  };

  return (
    <div className="p-6">
      <h2 className="text-xl mb-4">Messages</h2>

      <div className="border h-64 overflow-y-scroll mb-4 p-2">
        {messages.map((msg, i) => (
          <p key={i}>{msg.message}</p>
        ))}
      </div>

      <input
        value={message}
        onChange={(e) => setMessage(e.target.value)}
        className="border p-2 w-full mb-2"
      />
      <button onClick={sendMessage} className="bg-blue-600 text-white px-4 py-2">
        Send
      </button>
    </div>
  );
}

export default MessagesPage;
