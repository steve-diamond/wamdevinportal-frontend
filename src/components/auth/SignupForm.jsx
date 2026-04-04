import React, { useState } from 'react';

const SignupForm = ({ onSubmit, loading, error }) => {
  const [form, setForm] = useState({ fullName: '', email: '', password: '' });

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(form);
  };

  return (
    <form onSubmit={handleSubmit} style={{ maxWidth: 320, margin: '0 auto', padding: 24, border: '1px solid #ccc', borderRadius: 8 }}>
      <h2>Signup</h2>
      <input name="fullName" placeholder="Full Name" value={form.fullName} onChange={handleChange} required />
      <input name="email" type="email" placeholder="Email" value={form.email} onChange={handleChange} required />
      <input name="password" type="password" placeholder="Password" value={form.password} onChange={handleChange} required />
      <button type="submit" disabled={loading}>{loading ? 'Signing up...' : 'Signup'}</button>
      {error && <div style={{ color: 'red', marginTop: 8 }}>{error}</div>}
    </form>
  );
};

export default SignupForm;
