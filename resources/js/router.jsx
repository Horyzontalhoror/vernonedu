import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useEffect, useState } from "react";

import Home from "./pages/Home/Home";
import Program from "./pages/Program/Program";
import Jadwal from "./pages/Jadwal/Jadwal";

import Dashboard from "./pages/Dashboard/Dashboard";
import MyCourse from "./pages/Dashboard/MyCourse/MyCourse";
import MyCourseDetail from "./pages/Dashboard/MyCourse/MyCourseDetail";
import MyCalendar from "./pages/Dashboard/Calendar/MyCalendar";
import MyCertificate from "./pages/Dashboard/Certificate/MyCertificate";
import CertificateDetail from "./pages/Dashboard/Certificate/CertificateDetail";
import Announcement from "./pages/Dashboard/Announcement/Announcement";
import Profile from "./pages/Dashboard/Profile/Profile";
import Notifications from "./pages/Dashboard/Notification/Notifications";

import ProtectedRoute from "./components/ProtectedRoute";
import Checkout from "./pages/Checkout/Checkout";
import AuthModal from "./auth/AuthModal";

export default function Router() {

    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [showAuth, setShowAuth] = useState(false);

    // 🔥 ambil user
    const fetchUser = async () => {

        const token = localStorage.getItem("token");

        if (!token) {
            setUser(null);
            return;
        }

        try {

            const res = await fetch(
                "http://localhost:8000/api/me",
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }
            );

            const data = await res.json();

            setUser(data);

        } catch {

            localStorage.removeItem("token");

            setUser(null);

        }
    };

    useEffect(() => {

        fetchUser().finally(() =>
            setLoading(false)
        );

    }, []);

    useEffect(() => {

        const handler = () =>
            setShowAuth(true);

        window.addEventListener(
            "open-auth",
            handler
        );

        return () =>
            window.removeEventListener(
                "open-auth",
                handler
            );

    }, []);

    if (loading) {

        return (
            <div className="p-10">
                Loading...
            </div>
        );

    }

    return (

        <BrowserRouter>

            <Routes>

                {/* PUBLIC */}
                <Route
                    path="/"
                    element={<Home />}
                />

                <Route
                    path="/program"
                    element={<Program />}
                />

                <Route
                    path="/program/:slug"
                    element={<Program />}
                />

                <Route
                    path="/jadwal"
                    element={<Jadwal />}
                />

                {/* PROTECTED */}
                <Route
                    path="/checkout/:id"
                    element={
                        <ProtectedRoute
                            user={user}
                            onAuthRequired={() =>
                                setShowAuth(true)
                            }
                        >
                            <Checkout />
                        </ProtectedRoute>
                    }
                />

                <Route
                    path="/dashboard"
                    element={
                        <ProtectedRoute
                            user={user}
                            onAuthRequired={() =>
                                setShowAuth(true)
                            }
                        >
                            <Dashboard user={user} />
                        </ProtectedRoute>
                    }
                >

                    <Route
                        index
                        element={<MyCourse />}
                    />

                    <Route
                    path="course/:slug"
                    element={<MyCourseDetail />}
                    />

                    <Route
                        path="calendar"
                        element={<MyCalendar />}
                    />

                    <Route
                        path="certificate"
                        element={<MyCertificate />}
                    />

                    <Route
                        path="certificate/:slug"
                        element={<CertificateDetail />}
                    />

                    <Route
                        path="announcement"
                        element={<Announcement />}
                    />

                    <Route
                        path="profile"
                        element={<Profile />}
                    />

                    <Route
                        path="notifications"
                        element={<Notifications />}
                    />

                </Route>

            </Routes>

            {/* AUTH MODAL */}
            <AuthModal
                open={showAuth}
                onClose={() =>
                    setShowAuth(false)
                }
                onLoginSuccess={() => {

                    fetchUser();

                    setShowAuth(false);

                }}
            />

        </BrowserRouter>
    );
}
