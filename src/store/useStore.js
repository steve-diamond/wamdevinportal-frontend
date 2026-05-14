import { create } from 'zustand';
import { persist } from 'zustand/middleware';

let toastId = 0;

const useStore = create(persist((set, get) => ({
  // ── Auth ──
  user: null,
  loading: false,
  error: null,
  /** pendingMfa: true while waiting for user to enter OTP code */
  pendingMfa: false,
  /** mfaTempToken: short-lived token returned after first factor success */
  mfaTempToken: null,

  setUser: (user) => set({ user, pendingMfa: false, mfaTempToken: null }),
  setLoading: (loading) => set({ loading }),
  setError: (error) => set({ error }),
  setPendingMfa: (mfaTempToken) => set({ pendingMfa: true, mfaTempToken }),
  clearMfa: () => set({ pendingMfa: false, mfaTempToken: null }),
  logout: () => {
    localStorage.removeItem('token');
    set({ user: null, pendingMfa: false, mfaTempToken: null, notifications: [] });
  },

  // ── Toast notifications (queue) ──
  toasts: [],
  /**
   * Push a toast. type: 'success' | 'error' | 'warning' | 'info'
   * Returns the id so callers can dismiss early.
   */
  addToast: (message, type = 'info', title = '', duration = 4000) => {
    const id = ++toastId;
    set(state => ({ toasts: [...state.toasts, { id, message, type, title, duration }] }));
    if (duration > 0) {
      setTimeout(() => get().removeToast(id), duration);
    }
    return id;
  },
  removeToast: (id) =>
    set(state => ({ toasts: state.toasts.filter(t => t.id !== id) })),

  // ── Legacy single notification (kept for backward compat) ──
  notification: '',
  setNotification: (notification) => {
    set({ notification });
    if (notification) {
      get().addToast(notification, 'info');
      setTimeout(() => set({ notification: '' }), 4000);
    }
  },

  // ── In-app notification feed ──
  notifications: [],
  addNotification: (notif) =>
    set(state => ({
      notifications: [{ ...notif, id: Date.now(), read: false, ts: new Date().toISOString() }, ...state.notifications].slice(0, 50),
    })),
  markNotificationRead: (id) =>
    set(state => ({
      notifications: state.notifications.map(n => n.id === id ? { ...n, read: true } : n),
    })),
  markAllNotificationsRead: () =>
    set(state => ({
      notifications: state.notifications.map(n => ({ ...n, read: true })),
    })),

  // ── Search ──
  globalSearch: '',
  setGlobalSearch: (q) => set({ globalSearch: q }),
}), {
  name: 'wamdin-alumni-portal-store',
  // Only persist user & notifications, not ephemeral UI state
  partialize: (state) => ({ user: state.user, notifications: state.notifications }),
}));

export default useStore;
