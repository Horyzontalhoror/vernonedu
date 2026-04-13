import { Navigate } from "react-router-dom";

export default function ProtectedRoute({ children }) {
  const token = localStorage.getItem("token");

  if (!token) {
    // return <Navigate to="/login" state={{ from: location }} replace />;
    // onAuthRequired();
    return <div className="p-10 text-center">Silakan login...</div>;
  }

  return children;
}
