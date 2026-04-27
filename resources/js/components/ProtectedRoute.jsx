import { Navigate } from "react-router-dom";

export default function ProtectedRoute({ children, onAuthRequired }) {
  const token = localStorage.getItem("token");

  if (!token) {
    onAuthRequired?.(); // 🔥 trigger modal
    return null; // jangan render apa-apa
  }

  return children;
}

