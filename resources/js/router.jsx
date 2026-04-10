import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useEffect, useState } from "react";

import Home from "./pages/Home/Home";
import Program from "./pages/Program/Program";
import Jadwal from "./pages/Jadwal/Jadwal";

import Dashboard from "./pages/Dashboard/Dashboard";
import MyCourse from "./pages/Dashboard/MyCourse/MyCourse";
import MyCalendar from "./pages/Dashboard/Calendar/MyCalendar";
import MyCertificate from "./pages/Dashboard/Certificate/MyCertificate";
import CertificateDetail from "./pages/Dashboard/Certificate/CertificateDetail";
import Announcement from "./pages/Dashboard/Announcement/Announcement";

import ProtectedRoute from "./components/ProtectedRoute";

export default function Router() {

  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true); // 🔥 penting

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (!token) {
      setLoading(false);
      return;
    }

    fetch("http://localhost:8000/api/me", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then(res => res.json())
      .then(data => setUser(data))
      .catch(() => {
        localStorage.removeItem("token");
      })
      .finally(() => setLoading(false)); // 🔥 selesai loading
  }, []);

  // 🔥 TUNGGU USER SELESAI LOAD
  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <BrowserRouter>
      <Routes>

        {/* PUBLIC */}
        <Route path="/" element={<Home />} />
        <Route path="/program" element={<Program />} />
        <Route path="/program/:slug" element={<Program />} />
        <Route path="/jadwal" element={<Jadwal />} />

        {/* PROTECTED */}
        <Route
          path="/dashboard"
          element={
            <ProtectedRoute user={user}>
              <Dashboard user={user} />
            </ProtectedRoute>
          }
        >
          <Route index element={<MyCourse />} />
          <Route path="calendar" element={<MyCalendar />} />
          <Route path="certificate" element={<MyCertificate />} />
          <Route path="certificate/:slug" element={<CertificateDetail />} />
          <Route path="announcement" element={<Announcement />} />
        </Route>

      </Routes>
    </BrowserRouter>
  );
}
