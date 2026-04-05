import React, { useState, useEffect } from 'react';
import SearchBar from '../components/SearchBar';
import FilterPanel from '../components/FilterPanel';
import AlumniCard from '../components/AlumniCard';
import api from '../api';

const AlumniDirectory = () => {
  const [search, setSearch] = useState('');
  const [filters, setFilters] = useState({});
  const [alumni, setAlumni] = useState([]);
  const [page, setPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [loading, setLoading] = useState(false);

  const fetchAlumni = async (params = {}) => {
    setLoading(true);
    try {
      const query = new URLSearchParams({
        name: search,
        ...filters,
        skills: filters.skills,
        page,
        limit: 10,
        ...params
      }).toString();
      const res = await api.get(`/api/users/search?${query}`);
      setAlumni(res.data.users);
      setTotalPages(res.data.pages);
    } catch (err) {
      setAlumni([]);
    }
    setLoading(false);
  };

  useEffect(() => {
    fetchAlumni();
    // eslint-disable-next-line
  }, [search, filters, page]);

  const handleConnect = (alumni) => {
    alert(`Connect request sent to ${alumni.fullName}`);
    // Implement connect logic here
  };

  const handleMessage = (alumni) => {
    alert(`Message dialog opened for ${alumni.fullName}`);
    // Implement message logic here
  };

  return (
    <div style={{ maxWidth: 700, margin: '0 auto', padding: 24 }}>
      <h2>Alumni Directory</h2>
      <SearchBar value={search} onChange={setSearch} onSearch={() => fetchAlumni({ page: 1 })} />
      <FilterPanel filters={filters} onChange={setFilters} />
      {loading ? <div>Loading...</div> : (
        alumni.length ? alumni.map(a => (
          <AlumniCard key={a._id} alumni={a} onConnect={handleConnect} onMessage={handleMessage} />
        )) : <div>No alumni found.</div>
      )}
      <div style={{ marginTop: 16 }}>
        <button onClick={() => setPage(p => Math.max(1, p - 1))} disabled={page === 1}>Prev</button>
        <span style={{ margin: '0 12px' }}>Page {page} of {totalPages}</span>
        <button onClick={() => setPage(p => Math.min(totalPages, p + 1))} disabled={page === totalPages}>Next</button>
      </div>
    </div>
  );
};

export default AlumniDirectory;
