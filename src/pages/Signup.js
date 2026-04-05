import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import useStore from '../store/useStore';
import api from '../api';

const Signup = () => {
  const [form, setForm] = useState({ fullName: '', email: '', password: '' });
  const { setNotification, setLoading, setError } = useStore();
  const navigate = useNavigate();

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      await api.post('/api/auth/signup', form);
      setNotification('Signup successful! Please verify your email.');
      navigate('/login');
    } catch (err) {
      setError('Signup failed');
      setNotification('Signup failed');
    }
    setLoading(false);
  };

  return (
    <form onSubmit={handleSubmit} style={{ maxWidth: 320, margin: '60px auto', padding: 24, border: '1px solid #ccc', borderRadius: 8 }}>
      <h2>Signup</h2>
      <input name="fullName" placeholder="Full Name" value={form.fullName} onChange={handleChange} required />
      <input name="email" type="email" placeholder="Email" value={form.email} onChange={handleChange} required />
      <input name="password" type="password" placeholder="Password" value={form.password} onChange={handleChange} required />
      <button type="submit">Signup</button>
    </form>
  );
};

export default Signup;
