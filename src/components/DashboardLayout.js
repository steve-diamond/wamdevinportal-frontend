import React, { useState, useEffect, useRef } from 'react';
import { NavLink, useNavigate, useLocation } from 'react-router-dom';
import useStore from '../store/useStore';
import '../styles/dashboard.css';

const NAV_SECTIONS = [
  {
    label: 'Main',
    items: [
      { to: '/dashboard', icon: '🏠', label: 'Dashboard', roles: ['alumni', 'admin', 'membership'] },
      { to: '/profile', icon: '👤', label: 'My Profile', roles: ['alumni', 'admin', 'membership'] },
    ],
  },
  {
    label: 'Community',
    items: [
      { to: '/alumni', icon: '🎓', label: 'Alumni Directory', roles: ['alumni', 'admin', 'membership'] },
      { to: '/events', icon: '📅', label: 'Events', roles: ['alumni', 'admin', 'membership'] },
      { to: '/messaging', icon: '💬', label: 'Messages', roles: ['alumni', 'admin', 'membership'] },
      { to: '/resources', icon: '📚', label: 'Resources', roles: ['alumni', 'admin', 'membership'] },
    ],
  },
  {
    label: 'Administration',
    items: [
      { to: '/admin', icon: '⚙️', label: 'Admin Panel', roles: ['admin'] },
    ],
  },
];

export default function DashboardLayout({ children, title = 'Dashboard' }) {
  const [collapsed, setCollapsed] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const [userMenuOpen, setUserMenuOpen] = useState(false);
  const { user, logout, notifications } = useStore();
  const navigate = useNavigate();
  const location = useLocation();
  const userMenuRef = useRef(null);
  const unreadCount = (notifications || []).filter(n => !n.read).length;

  // Close mobile sidebar on route change
  useEffect(() => { setMobileOpen(false); }, [location.pathname]);

  // Close user menu on outside click
  useEffect(() => {
    const handler = (e) => {
      if (userMenuRef.current && !userMenuRef.current.contains(e.target)) {
        setUserMenuOpen(false);
      }
    };
    document.addEventListener('mousedown', handler);
    return () => document.removeEventListener('mousedown', handler);
  }, []);

  const handleLogout = () => {
    logout();
    localStorage.removeItem('token');
    navigate('/portal/alumni');
  };

  const initials = user?.fullName
    ? user.fullName.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2)
    : 'U';

  const role = user?.role || 'alumni';

  return (
    <div className="portal-shell" role="application">
      {/* Accessibility skip link */}
      <a href="#main-content" className="skip-link">Skip to main content</a>

      {/* Mobile overlay */}
      {mobileOpen && (
        <div
          role="presentation"
          aria-hidden="true"
          style={{
            position: 'fixed', inset: 0, background: 'rgba(0,0,0,0.4)',
            zIndex: 199, display: 'none',
          }}
          className="mobile-overlay"
          onClick={() => setMobileOpen(false)}
        />
      )}

      {/* ── Sidebar ── */}
      <aside
        className={`portal-sidebar${collapsed ? ' collapsed' : ''}${mobileOpen ? ' mobile-open' : ''}`}
        aria-label="Primary navigation"
      >
        <div className="sidebar-brand">
          <img
            src="/wamdevin-full/assets/images/logo.png"
            alt="WAMDIN logo"
            onError={e => { e.target.style.display = 'none'; }}
          />
          <span className="sidebar-brand-text" aria-hidden={collapsed}>WAMDIN Portal</span>
        </div>

        <nav className="sidebar-nav" aria-label="Sidebar navigation">
          {NAV_SECTIONS.map(section => {
            const visibleItems = section.items.filter(item =>
              item.roles.includes(role)
            );
            if (!visibleItems.length) return null;
            return (
              <div key={section.label}>
                <div className="sidebar-section-label" aria-hidden="true">
                  {section.label}
                </div>
                {visibleItems.map(item => (
                  <NavLink
                    key={item.to}
                    to={item.to}
                    className={({ isActive }) =>
                      `sidebar-link${isActive ? ' active' : ''}`
                    }
                    aria-current={location.pathname === item.to ? 'page' : undefined}
                    title={collapsed ? item.label : undefined}
                  >
                    <span className="sidebar-link-icon" aria-hidden="true">{item.icon}</span>
                    <span className="sidebar-link-label">{item.label}</span>
                  </NavLink>
                ))}
              </div>
            );
          })}
        </nav>

        <div className="sidebar-footer">
          <button onClick={handleLogout} aria-label="Sign out">
            <span aria-hidden="true">🚪</span>
            <span className="sidebar-link-label">Sign Out</span>
          </button>
        </div>
      </aside>

      {/* ── Main ── */}
      <div className="portal-main">
        {/* Top Bar */}
        <header className="portal-topbar" role="banner">
          <button
            className="topbar-toggle"
            onClick={() => {
              if (window.innerWidth <= 768) {
                setMobileOpen(o => !o);
              } else {
                setCollapsed(o => !o);
              }
            }}
            aria-label={collapsed ? 'Expand sidebar' : 'Collapse sidebar'}
            aria-expanded={!collapsed}
            aria-controls="sidebar"
          >
            ☰
          </button>

          <div className="topbar-breadcrumb" aria-label="Current page">{title}</div>

          <div className="topbar-search" role="search">
            <span className="search-icon" aria-hidden="true">🔍</span>
            <input
              type="search"
              placeholder="Search…"
              aria-label="Global search"
              onKeyDown={e => {
                if (e.key === 'Enter' && e.target.value.trim()) {
                  navigate(`/alumni?q=${encodeURIComponent(e.target.value.trim())}`);
                }
              }}
            />
          </div>

          <div className="topbar-actions">
            {/* Notifications */}
            <button
              className="topbar-icon-btn"
              aria-label={`Notifications${unreadCount ? `, ${unreadCount} unread` : ''}`}
              onClick={() => navigate('/dashboard?tab=notifications')}
            >
              🔔
              {unreadCount > 0 && (
                <span className="notif-badge" aria-hidden="true">
                  {unreadCount > 9 ? '9+' : unreadCount}
                </span>
              )}
            </button>

            {/* User menu */}
            <div style={{ position: 'relative' }} ref={userMenuRef}>
              <button
                className="topbar-avatar"
                onClick={() => setUserMenuOpen(o => !o)}
                aria-label="User menu"
                aria-expanded={userMenuOpen}
                aria-haspopup="menu"
              >
                {initials}
              </button>

              {userMenuOpen && (
                <div
                  role="menu"
                  style={{
                    position: 'absolute', top: '100%', right: 0, marginTop: 6,
                    background: 'var(--surface)', border: '1px solid var(--border)',
                    borderRadius: 10, boxShadow: 'var(--shadow-md)', minWidth: 180,
                    zIndex: 500, overflow: 'hidden',
                  }}
                >
                  <div style={{ padding: '12px 16px', borderBottom: '1px solid var(--border)' }}>
                    <div style={{ fontWeight: 700, fontSize: 13 }}>{user?.fullName || 'User'}</div>
                    <div style={{ fontSize: 11, color: 'var(--text-secondary)', marginTop: 2 }}>
                      {user?.email}
                    </div>
                    <div style={{ marginTop: 4 }}>
                      <span className={`badge badge-${role === 'admin' ? 'danger' : 'primary'}`}>
                        {role}
                      </span>
                    </div>
                  </div>
                  {[
                    { label: '👤 My Profile', to: '/profile' },
                    { label: '⚙️ Settings', to: '/profile?tab=settings' },
                  ].map(item => (
                    <button
                      key={item.to}
                      role="menuitem"
                      style={{
                        display: 'block', width: '100%', textAlign: 'left',
                        padding: '10px 16px', border: 'none', background: 'transparent',
                        cursor: 'pointer', fontSize: 13, color: 'var(--text-primary)',
                        transition: 'background var(--transition)',
                      }}
                      onMouseEnter={e => e.target.style.background = 'var(--bg)'}
                      onMouseLeave={e => e.target.style.background = 'transparent'}
                      onClick={() => { setUserMenuOpen(false); navigate(item.to); }}
                    >
                      {item.label}
                    </button>
                  ))}
                  <button
                    role="menuitem"
                    style={{
                      display: 'block', width: '100%', textAlign: 'left',
                      padding: '10px 16px', border: 'none', background: 'transparent',
                      cursor: 'pointer', fontSize: 13, color: 'var(--danger)',
                      borderTop: '1px solid var(--border)',
                    }}
                    onClick={handleLogout}
                  >
                    🚪 Sign Out
                  </button>
                </div>
              )}
            </div>
          </div>
        </header>

        {/* Content */}
        <main id="main-content" className="portal-content page-fade" tabIndex="-1">
          {children}
        </main>
      </div>
    </div>
  );
}
