import create from 'zustand';
import { persist } from 'zustand/middleware';

const useStore = create(persist((set) => ({
  user: null,
  loading: false,
  error: null,
  notification: '',
  setUser: (user) => set({ user }),
  setLoading: (loading) => set({ loading }),
  setError: (error) => set({ error }),
  setNotification: (notification) => set({ notification }),
  logout: () => set({ user: null }),
}), { name: 'wamdin-alumni-portal-store' }));

export default useStore;
