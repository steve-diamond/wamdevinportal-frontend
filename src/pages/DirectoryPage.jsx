import React, { useEffect, useState } from 'react';
import axios from 'axios';

function DirectoryPage() {
  const [users, setUsers] = useState([]);
  const [search, setSearch] = useState('');

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    const res = await axios.get(`http://localhost:5000/api/users?name=${search}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    });
    setUsers(res.data.users);
  };

  return (
    <div className="p-6">
      <h2 className="text-xl mb-4">Alumni Directory</h2>

      <input
        type="text"
        placeholder="Search alumni..."
        value={search}
        onChange={(e) => setSearch(e.target.value)}
        className="border p-2 mb-4 w-full"
      />

      <button onClick={fetchUsers} className="bg-blue-600 text-white px-4 py-2 mb-4">
        Search
      </button>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {users.map((user) => (
          <div key={user._id} className="border p-4 rounded shadow">
            <h3 className="font-bold">{user.fullName}</h3>
            <p>{user.currentPosition}</p>
            <p>{user.country}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default DirectoryPage;
