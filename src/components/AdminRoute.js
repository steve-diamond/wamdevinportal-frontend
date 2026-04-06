import React from 'react';
import { Navigate } from 'react-router-dom';
import useStore from '../store/useStore';

const AdminRoute = ({ children }) => {
  const { user } = useStore();
  if (!user || user.role !== 'admin') return <Navigate to="/portal/admin" replace />;
  return children;
};

export default AdminRoute;
