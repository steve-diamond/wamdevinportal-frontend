import axios from 'axios';

const api = axios.create({
  baseURL: process.env.REACT_APP_API_URL || 'http://localhost:5000',
  withCredentials: false,
  timeout: 15000,
});

// Attach JWT on every request
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  (error) => Promise.reject(error)
);

// Handle 401 globally — clear session and redirect to login
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token');
      // Lazy import to avoid circular dependency
      import('./store/useStore').then(({ default: useStore }) => {
        useStore.getState().logout();
      });
      if (!window.location.pathname.startsWith('/portal')) {
        window.location.replace('/portal/alumni');
      }
    }
    return Promise.reject(error);
  }
);

export default api;
