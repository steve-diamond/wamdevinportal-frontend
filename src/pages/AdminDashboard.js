import React, { useEffect, useState, useCallback, Suspense, lazy, useRef } from 'react';
import axios from 'axios';
import useStore from '../store/useStore';
import DashboardLayout from '../components/DashboardLayout';
import UserTable from '../components/UserTable';
import EventManagementPanel from '../components/EventManagementPanel';
import ResourceApprovalPanel from '../components/ResourceApprovalPanel';
import { exportCSV } from '../utils/exportUtils';
import '../styles/dashboard.css';

const ChartsPanel = lazy(() => import('../components/ChartsPanel'));

const ADMIN_TABS = [
  { id: 'overview',   label: '📊 Overview' },
  { id: 'users',      label: '👥 Users' },
  { id: 'events',     label: '📅 Events' },
  { id: 'resources',  label: '📚 Resources' },
];

const STAT_COLORS = ['', 'success', 'info', 'warning'];

function ConfirmDialog({ message, onConfirm, onCancel }) {
  const btnRef = useRef(null);
  useEffect(() => { btnRef.current?.focus(); }, []);
  return (
    <div
      role="dialog"
      aria-modal="true"
      aria-label="Confirm action"
      style={{
        position: 'fixed', inset: 0, background: 'rgba(0,0,0,0.45)',
        display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 9999,
      }}
    >
      <div style={{
        background: 'var(--surface)', borderRadius: 12, padding: 28,
        maxWidth: 380, width: '92%', boxShadow: 'var(--shadow-lg)',
      }}>
        <div style={{ fontWeight: 700, fontSize: 16, marginBottom: 10 }}>⚠ Confirm Action</div>
        <p style={{ fontSize: 14, color: 'var(--text-secondary)', marginBottom: 20 }}>{message}</p>
        <div style={{ display: 'flex', gap: 10, justifyContent: 'flex-end' }}>
          <button className="btn btn-secondary" onClick={onCancel}>Cancel</button>
          <button ref={btnRef} className="btn btn-danger" onClick={onConfirm}>Confirm</button>
        </div>
      </div>
    </div>
  );
}

function SearchFilterBar({ value, onChange, placeholder = 'Search…', onExport }) {
  return (
    <div style={{ display: 'flex', gap: 8, alignItems: 'center', flexWrap: 'wrap' }}>
      <div style={{ position: 'relative', flex: 1, minWidth: 180 }}>
        <span style={{ position: 'absolute', left: 10, top: '50%', transform: 'translateY(-50%)', color: 'var(--text-muted)', fontSize: 14 }} aria-hidden="true">🔍</span>
        <input
          type="search"
          aria-label={placeholder}
          placeholder={placeholder}
          value={value}
          onChange={e => onChange(e.target.value)}
          className="form-input"
          style={{ paddingLeft: 32, width: '100%' }}
        />
      </div>
      {onExport && (
        <button className="btn btn-secondary btn-sm" onClick={onExport} aria-label="Export as CSV">
          ⬇ CSV
        </button>
      )}
    </div>
  );
}

export default function AdminDashboard() {
  const [users, setUsers]       = useState([]);
  const [events, setEvents]     = useState([]);
  const [resources, setResources] = useState([]);
  const [stats, setStats]       = useState([]);
  const [activeTab, setActiveTab] = useState('overview');
  const [userSearch, setUserSearch] = useState('');
  const [eventSearch, setEventSearch] = useState('');
  const [resourceSearch, setResourceSearch] = useState('');
  const [confirm, setConfirm]   = useState(null); // { message, onConfirm }
  const { addToast } = useStore();

  const fetchAll = useCallback(() => {
    const token = localStorage.getItem('token');
    const headers = token ? { Authorization: `Bearer ${token}` } : {};

    axios.get('/api/admin/users', { headers })
      .then(r => setUsers(r.data))
      .catch(() => {});

    axios.get('/api/admin/events', { headers })
      .then(r => setEvents(r.data))
      .catch(() => {});

    axios.get('/api/admin/resources', { headers })
      .then(r => setResources(r.data))
      .catch(() => {});

    axios.get('/api/admin/analytics', { headers })
      .then(r => {
        setStats([
          { name: 'Total Users',   count: r.data.users },
          { name: 'Events',        count: r.data.events },
          { name: 'Resources',     count: r.data.resources },
          { name: 'RSVPs',         count: r.data.registrations },
        ]);
      })
      .catch(() => {});
  }, []);

  useEffect(() => { fetchAll(); }, [fetchAll]);

  const confirmThen = (message, fn) => setConfirm({ message, onConfirm: fn });

  const handleEdit   = (item) => addToast('Edit feature coming soon.', 'info', 'Edit');
  const handleDelete = (item) =>
    confirmThen(`Delete "${item.fullName || item.title || item.name}"?`, () => {
      setConfirm(null);
      addToast('Item deleted.', 'success', 'Deleted');
    });

  const filteredUsers = users.filter(u =>
    !userSearch ||
    [u.fullName, u.email, u.role].some(f => f?.toLowerCase().includes(userSearch.toLowerCase()))
  );

  const filteredEvents = events.filter(e =>
    !eventSearch || (e.title || '').toLowerCase().includes(eventSearch.toLowerCase())
  );

  const filteredResources = resources.filter(r =>
    !resourceSearch || (r.title || r.name || '').toLowerCase().includes(resourceSearch.toLowerCase())
  );

  return (
    <DashboardLayout title="Admin Dashboard">
      {confirm && (
        <ConfirmDialog
          message={confirm.message}
          onConfirm={confirm.onConfirm}
          onCancel={() => setConfirm(null)}
        />
      )}

      {/* Page header */}
      <div className="page-header">
        <div>
          <h1>⚙️ Admin Dashboard</h1>
          <p>Manage users, events, resources and review analytics.</p>
        </div>
        <div className="page-header-actions">
          <button className="btn btn-secondary btn-sm" onClick={fetchAll} aria-label="Refresh data">
            🔄 Refresh
          </button>
        </div>
      </div>

      {/* Tabs */}
      <div
        role="tablist"
        aria-label="Admin sections"
        style={{ display: 'flex', gap: 4, marginBottom: 20, borderBottom: '1px solid var(--border)', paddingBottom: 0, flexWrap: 'wrap' }}
      >
        {ADMIN_TABS.map(tab => (
          <button
            key={tab.id}
            role="tab"
            aria-selected={activeTab === tab.id}
            aria-controls={`admin-panel-${tab.id}`}
            id={`admin-tab-${tab.id}`}
            onClick={() => setActiveTab(tab.id)}
            style={{
              padding: '8px 16px', border: 'none', cursor: 'pointer', background: 'transparent',
              fontSize: 13, fontWeight: 600,
              borderBottom: activeTab === tab.id ? '2px solid var(--primary)' : '2px solid transparent',
              color: activeTab === tab.id ? 'var(--primary)' : 'var(--text-secondary)',
              transition: 'color 150ms, border-color 150ms', marginBottom: -1, whiteSpace: 'nowrap',
            }}
          >
            {tab.label}
          </button>
        ))}
      </div>

      {/* ── Overview ── */}
      {activeTab === 'overview' && (
        <div role="tabpanel" id="admin-panel-overview" aria-labelledby="admin-tab-overview" className="page-fade">
          <div className="stats-grid">
            {stats.map((s, i) => (
              <article key={s.name} className={`stat-card ${STAT_COLORS[i] || ''}`} tabIndex="0">
                <div className="stat-card-value">{s.count ?? '—'}</div>
                <div className="stat-card-label">{s.name}</div>
              </article>
            ))}
          </div>

          <div className="panel">
            <div className="panel-header">
              <h2>📊 Analytics Chart</h2>
              <button
                className="btn btn-secondary btn-sm"
                onClick={() => exportCSV(stats.map(s => ({ metric: s.name, value: s.count })), 'admin-analytics')}
              >
                ⬇ Export CSV
              </button>
            </div>
            <div className="panel-body">
              <Suspense fallback={<div className="skeleton" style={{ height: 220 }} />}>
                <ChartsPanel stats={stats} />
              </Suspense>
            </div>
          </div>
        </div>
      )}

      {/* ── Users ── */}
      {activeTab === 'users' && (
        <div role="tabpanel" id="admin-panel-users" aria-labelledby="admin-tab-users" className="page-fade">
          <div className="panel">
            <div className="panel-header" style={{ gap: 12 }}>
              <h2>👥 Users ({filteredUsers.length})</h2>
              <SearchFilterBar
                value={userSearch}
                onChange={setUserSearch}
                placeholder="Search users…"
                onExport={() => exportCSV(
                  filteredUsers.map(u => ({ name: u.fullName, email: u.email, role: u.role })),
                  'users-export'
                )}
              />
            </div>
            <div className="panel-body no-pad" style={{ overflowX: 'auto' }}>
              <UserTable users={filteredUsers} onEdit={handleEdit} onDelete={handleDelete} />
            </div>
          </div>
        </div>
      )}

      {/* ── Events ── */}
      {activeTab === 'events' && (
        <div role="tabpanel" id="admin-panel-events" aria-labelledby="admin-tab-events" className="page-fade">
          <div className="panel">
            <div className="panel-header" style={{ gap: 12 }}>
              <h2>📅 Events ({filteredEvents.length})</h2>
              <SearchFilterBar
                value={eventSearch}
                onChange={setEventSearch}
                placeholder="Search events…"
                onExport={() => exportCSV(
                  filteredEvents.map(e => ({ title: e.title, date: e.date, location: e.location })),
                  'events-export'
                )}
              />
            </div>
            <div className="panel-body no-pad" style={{ overflowX: 'auto' }}>
              <EventManagementPanel events={filteredEvents} onEdit={handleEdit} onDelete={handleDelete} />
            </div>
          </div>
        </div>
      )}

      {/* ── Resources ── */}
      {activeTab === 'resources' && (
        <div role="tabpanel" id="admin-panel-resources" aria-labelledby="admin-tab-resources" className="page-fade">
          <div className="panel">
            <div className="panel-header" style={{ gap: 12 }}>
              <h2>📚 Resources ({filteredResources.length})</h2>
              <SearchFilterBar
                value={resourceSearch}
                onChange={setResourceSearch}
                placeholder="Search resources…"
                onExport={() => exportCSV(
                  filteredResources.map(r => ({ title: r.title || r.name, type: r.type, status: r.status })),
                  'resources-export'
                )}
              />
            </div>
            <div className="panel-body no-pad" style={{ overflowX: 'auto' }}>
              <ResourceApprovalPanel resources={filteredResources} onEdit={handleEdit} onDelete={handleDelete} />
            </div>
          </div>
        </div>
      )}
    </DashboardLayout>
  );
}

