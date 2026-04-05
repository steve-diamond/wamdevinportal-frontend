import React, { useState } from 'react';

const MessageInput = ({ onSend }) => {
  const [value, setValue] = useState('');
  return (
    <form
      onSubmit={e => {
        e.preventDefault();
        if (value.trim()) {
          onSend(value);
          setValue('');
        }
      }}
      style={{ display: 'flex', gap: 8, marginTop: 8 }}
    >
      <input
        type="text"
        value={value}
        onChange={e => setValue(e.target.value)}
        placeholder="Type a message..."
        style={{ flex: 1 }}
      />
      <button type="submit">Send</button>
    </form>
  );
};

export default MessageInput;
