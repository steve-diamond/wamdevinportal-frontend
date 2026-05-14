import React, { useState, useEffect } from 'react';
import useStore from '../store/useStore';
import '../styles/dashboard.css';

const ICONS = {
  success: '✅',
  error:   '❌',
  warning: '⚠️',
  info:    'ℹ️',
};

const TITLES = {
  success: 'Success',
  error:   'Error',
  warning: 'Warning',
  info:    'Info',
};

function Toast({ toast, onClose }) {
  const [exiting, setExiting] = useState(false);

  const dismiss = () => {
    setExiting(true);
    setTimeout(() => onClose(toast.id), 260);
  };

  // Trigger exit animation shortly before the store auto-removes it
  useEffect(() => {
    if (toast.duration > 0) {
      const t = setTimeout(() => setExiting(true), toast.duration - 300);
      return () => clearTimeout(t);
    }
  }, [toast.duration]);

  return (
    <div
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
      className={`toast ${toast.type || 'info'}${exiting ? ' exiting' : ''}`}
    >
      <span className="toast-icon" aria-hidden="true">
        {ICONS[toast.type] || ICONS.info}
      </span>
      <div className="toast-body">
        <div className="toast-title">
          {toast.title || TITLES[toast.type] || 'Notification'}
        </div>
        {toast.message && (
          <div className="toast-message">{toast.message}</div>
        )}
      </div>
      <button
        className="toast-close"
        onClick={dismiss}
        aria-label="Dismiss notification"
      >
        ×
      </button>
    </div>
  );
}

export default function Notification() {
  const { toasts, removeToast } = useStore();

  if (!toasts?.length) return null;

  return (
    <div className="toast-container" aria-label="Notifications">
      {toasts.map(t => (
        <Toast key={t.id} toast={t} onClose={removeToast} />
      ))}
    </div>
  );
}

