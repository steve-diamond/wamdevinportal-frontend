import React from 'react';

const UserTable = ({ users, onEdit, onDelete }) => (
  <table style={{ width: '100%', borderCollapse: 'collapse' }}>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      {users.map(user => (
        <tr key={user._id}>
          <td>{user.fullName}</td>
          <td>{user.email}</td>
          <td>{user.role}</td>
          <td>
            <button onClick={() => onEdit(user)}>Edit</button>
            <button onClick={() => onDelete(user)} style={{ marginLeft: 8 }}>Delete</button>
          </td>
        </tr>
      ))}
    </tbody>
  </table>
);

export default UserTable;
