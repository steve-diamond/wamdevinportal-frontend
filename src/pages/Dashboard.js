import React, { useEffect, useState, useCallback, Suspense, lazy } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import useStore from '../store/useStore';
import api from '../api';
import DashboardLayout from '../components/DashboardLayout';
import OnboardingGuide from '../components/OnboardingGuide';
import '../styles/dashboard.css';

const ChartsPanel = lazy(() => import('../components/ChartsPanel'));

const STAT_CONFIGS = [
  { key: 'alumni',        label: 'Alumni Members',   icon: '🎓', variant: '',        delta: '+12 this month' },
  { key: 'events',        label: 'Upcoming Events',  icon: '📅', variant: 'success', delta: '3 this week' },
  { key: 'resources',     label: 'Resources',        icon: '📚', variant: 'info',    delta: null },
  { key: 'registrations', label: 'Event RSVPs',      icon: '✅', variant: 'warning', delta: null },
];

const QUICK_ACTIONS = [
  { label: 'Browse Directory', icon: '🎓', to: '/alumni' },
  { label: 'View Events',      icon: '📅', to: '/events' },
  { label: 'Send Message',     icon: '💬', to: '/messaging' },
  { label: 'Resources',        icon: '📚', to: '/resources' },
];

function SkeletonCard() {
  return (
    <div className="stat-card" aria-hidden="true">
      <div className="skeleton" style={{ width: 32, height: 32, borderRadius: 6, marginBottom: 8 }} />
      <div className="skeleton" style={{ width: '60%', height: 28, marginBottom: 6 }} />
      <div className="skeleton" style={{ width: '80%', height: 14 }} />
    </div>
  );
}

export default function Dashboard() {
  const { user, notifications, markAllNotificationsRead, addToast } = useStore();
  const [stats, setStats] = useState(null);
  const [recentActivity, setRecentActivity] = useState([]);
  const [loadingStats, setLoadingStats] = useState(true);
  const [activeTab, setActiveTab] = useState('overview');
  const [showOnboarding, setShowOnboarding] = useState(false);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  useEffect(() => {
    if (searchParams.get('tab') === 'notifications') setActiveTab('notifications');
  }, [searchParams]);

  // Show onboarding for first-time users
  useEffect(() => {
    const seen = localStorage.getItem('wamdin-onboarding-done');
    if (!seen) setShowOnboarding(true);
  }, []);

  const fetchStats = useCallback(async () => {
    setLoadingStats(true);
    try {
      const res = await api.get('/api/admin/analytics');
      setStats(res.data);
    } catch {
      // Use placeholder data when API is unavailable
      setStats({ alumni: '—', events: '—', resources: '—', registrations: '—' });
    }
    setLoadingStats(false);
  }, []);

  const fetchActivity = useCallback(async () => {
    try {
      const res = await api.get('/api/admin/activity');
      setRecentActivity(res.data?.slice(0, 8) || []);
    } catch {
      setRecentActivity([]);
    }
  }, []);

  useEffect(() => {
    fetchStats();
    fetchActivity();
  }, [fetchStats, fetchActivity]);

  const handleOnboardingDone = () => {
    localStorage.setItem('wamdin-onboarding-done', '1');
    setShowOnboarding(false);
  };

  const unread = notifications.filter(n => !n.read);

  return (
    <DashboardLayout title="Dashboard">
      {/* Onboarding Guide */}
      {showOnboarding && (
        <OnboardingGuide onComplete={handleOnboardingDone} onSkip={handleOnboardingDone} />
      )}

      {/* ── Welcome header ── */}
      <div className="page-header">
        <div>
          <h1>Welcome back, {user?.fullName?.split(' ')[0] || 'there'}! 👋</h1>
          <p>Here's what's happening in your community today.</p>
        </div>
        <div className="page-header-actions">
          <button
            className="btn btn-secondary btn-sm"
            onClick={() => setShowOnboarding(true)}
            aria-label="Open onboarding guide"
          >
            ❓ Guide
          </button>
          <button
            className="btn btn-primary btn-sm"
            onClick={() => navigate('/events')}
          >
            + Register for Event
          </button>
        </div>
      </div>

      {/* ── Tabs ── */}
      <div
        role="tablist"
        aria-label="Dashboard sections"
        style={{ display: 'flex', gap: 4, marginBottom: 20, borderBottom: '1px solid var(--border)', paddingBottom: 0 }}
      >
        {[
          { id: 'overview',       label: 'Overview' },
          { id: 'notifications',  label: `Notifications${unread.length ? ` (${unread.length})` : ''}` },
          { id: 'activity',       label: 'Activity Feed' },
        ].map(tab => (
          <button
            key={tab.id}
            role="tab"
            aria-selected={activeTab === tab.id}
            aria-controls={`tabpanel-${tab.id}`}
            id={`tab-${tab.id}`}
            onClick={() => setActiveTab(tab.id)}
            style={{
              padding: '8px 16px', border: 'none', cursor: 'pointer', background: 'transparent',
              fontSize: 13, fontWeight: 600, borderBottom: activeTab === tab.id ? '2px solid var(--primary)' : '2px solid transparent',
              color: activeTab === tab.id ? 'var(--primary)' : 'var(--text-secondary)',
              transition: 'color 150ms, border-color 150ms',
              marginBottom: -1,
            }}
          >
            {tab.label}
          </button>
        ))}
      </div>

      {/* ── Overview Tab ── */}
      {activeTab === 'overview' && (
        <div role="tabpanel" id="tabpanel-overview" aria-labelledby="tab-overview" className="page-fade">
          {/* Stats */}
          <div className="stats-grid" aria-label="Key metrics">
            {loadingStats
              ? STAT_CONFIGS.map((_, i) => <SkeletonCard key={i} />)
              : STAT_CONFIGS.map(cfg => (
                  <article key={cfg.key} className={`stat-card ${cfg.variant}`} tabIndex="0">
                    <div className="stat-card-icon" aria-hidden="true">{cfg.icon}</div>
                    <div className="stat-card-value">{stats?.[cfg.key] ?? '—'}</div>
                    <div className="stat-card-label">{cfg.label}</div>
                    {cfg.delta && (
                      <div className="stat-card-delta up" aria-label={cfg.delta}>
                        ↑ {cfg.delta}
                      </div>
                    )}
                  </article>
                ))}
          </div>

          {/* Charts + Quick Actions */}
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 280px', gap: 16, alignItems: 'start' }}>
            <div className="panel" aria-label="Metrics chart">
              <div className="panel-header">
                <h2>📊 Metrics Overview</h2>
                <button
                  className="btn btn-secondary btn-sm"
                  onClick={() => {
                    import('../utils/exportUtils').then(m => m.exportCSV(
                      STAT_CONFIGS.map(c => ({ metric: c.label, value: stats?.[c.key] ?? 0 })),
                      'dashboard-metrics'
                    ));
                  }}
                  aria-label="Export metrics as CSV"
                >
                  ⬇ Export CSV
                </button>
              </div>
              <div className="panel-body">
                <Suspense fallback={<div className="skeleton" style={{ height: 200 }} />}>
                  <ChartsPanel
                    stats={stats ? STAT_CONFIGS.map(c => ({ name: c.label, value: stats[c.key] ?? 0 })) : []}
                  />
                </Suspense>
              </div>
            </div>

            <div className="panel">
              <div className="panel-header"><h2>⚡ Quick Actions</h2></div>
              <div className="panel-body" style={{ padding: 12, display: 'flex', flexDirection: 'column', gap: 8 }}>
                {QUICK_ACTIONS.map(a => (
                  <button
                    key={a.to}
                    className="btn btn-secondary"
                    style={{ justifyContent: 'flex-start', width: '100%', gap: 10 }}
                    onClick={() => navigate(a.to)}
                  >
                    <span aria-hidden="true">{a.icon}</span> {a.label}
                  </button>
                ))}
              </div>
            </div>
          </div>
        </div>
      )}

      {/* ── Notifications Tab ── */}
      {activeTab === 'notifications' && (
        <div role="tabpanel" id="tabpanel-notifications" aria-labelledby="tab-notifications" aria-live="polite" className="page-fade">
          <div className="panel">
            <div className="panel-header">
              <h2>🔔 Notifications</h2>
              {unread.length > 0 && (
                <button
                  className="btn btn-ghost btn-sm"
                  onClick={markAllNotificationsRead}
                >
                  Mark all read
                </button>
              )}
            </div>
            <div className="panel-body no-pad">
              {notifications.length === 0 ? (
                <div style={{ padding: 32, textAlign: 'center', color: 'var(--text-muted)' }}>
                  <div style={{ fontSize: 36, marginBottom: 8 }}>🔔</div>
                  <div>No notifications yet.</div>
                </div>
              ) : (
                <ul role="list" style={{ listStyle: 'none', margin: 0, padding: 0 }}>
                  {notifications.map(n => (
                    <li
                      key={n.id}
                      role="listitem"
                      style={{
                        padding: '12px 20px',
                        borderBottom: '1px solid var(--border)',
                        background: n.read ? 'transparent' : '#eff6ff',
                        display: 'flex',
                        gap: 12,
                        alignItems: 'flex-start',
                      }}
                    >
                      <span aria-hidden="true" style={{ fontSize: 20 }}>
                        {n.type === 'success' ? '✅' : n.type === 'error' ? '❌' : n.type === 'warning' ? '⚠️' : 'ℹ️'}
                      </span>
                      <div style={{ flex: 1 }}>
                        {n.title && <div style={{ fontWeight: 700, fontSize: 13 }}>{n.title}</div>}
                        <div style={{ fontSize: 13, color: 'var(--text-secondary)' }}>{n.message || n.title}</div>
                        <div style={{ fontSize: 11, color: 'var(--text-muted)', marginTop: 3 }}>
                          {new Date(n.ts).toLocaleString()}
                        </div>
                      </div>
                      {!n.read && (
                        <span
                          aria-label="Unread"
                          style={{ width: 8, height: 8, borderRadius: '50%', background: 'var(--primary)', marginTop: 5, flexShrink: 0 }}
                        />
                      )}
                    </li>
                  ))}
                </ul>
              )}
            </div>
          </div>
        </div>
      )}

      {/* ── Activity Tab ── */}
      {activeTab === 'activity' && (
        <div role="tabpanel" id="tabpanel-activity" aria-labelledby="tab-activity" className="page-fade">
          <div className="panel">
            <div className="panel-header"><h2>📋 Recent Activity</h2></div>
            <div className="panel-body no-pad">
              {recentActivity.length === 0 ? (
                <div style={{ padding: 32, textAlign: 'center', color: 'var(--text-muted)' }}>
                  <div style={{ fontSize: 36, marginBottom: 8 }}>📋</div>
                  <div>No recent activity to display.</div>
                </div>
              ) : (
                <table className="data-table" aria-label="Recent activity">
                  <thead>
                    <tr>
                      <th scope="col">Action</th>
                      <th scope="col">User</th>
                      <th scope="col">Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    {recentActivity.map((row, i) => (
                      <tr key={i}>
                        <td>{row.action}</td>
                        <td>{row.user || '—'}</td>
                        <td>{row.createdAt ? new Date(row.createdAt).toLocaleString() : '—'}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              )}
            </div>
          </div>
        </div>
      )}
    </DashboardLayout>
  );
}

