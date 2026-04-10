import { Link, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import AuthModal from "../auth/AuthModal";

import logo from "./assets/Logo Transparant.png";

export default function Navbar({ user }) {
  const [authOpen, setAuthOpen] = useState(false);
  const [isLogin, setIsLogin] = useState(false);
  const navigate = useNavigate();

  // 🔥 cek token (source of truth)
  useEffect(() => {
    const token = localStorage.getItem("token");
    setIsLogin(!!token);
  }, [user]);

  const handleLogout = () => {
    localStorage.removeItem("token");
    setIsLogin(false);
    navigate("/");
  };

  return (
    <>
      <nav className="sticky top-0 z-50 bg-white/80 backdrop-blur border-b">
        <div className="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

          {/* LOGO */}
          <div
            onClick={() => navigate("/")}
            className="flex items-center gap-2 cursor-pointer"
          >
            <img src={logo} alt="Logo" className="h-9" />
          </div>

          {/* MENU */}
          <div className="hidden md:flex gap-8 items-center text-xl font-medium text-slate-700">
            <Link className="hover:text-blue-500 transition" to="/">
              Home
            </Link>
            <Link className="hover:text-blue-500 transition" to="/program">
              Program
            </Link>
            <Link className="hover:text-blue-500 transition" to="/jadwal">
              Jadwal
            </Link>
          </div>

          {/* RIGHT SIDE */}
          <div className="flex items-center gap-3">

            {isLogin ? (
              <>
                {/* DASHBOARD BUTTON */}
                <button
                  onClick={() => navigate("/dashboard")}
                  className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition"
                >
                  Dashboard
                </button>

                {/* USER */}
                <div className="flex items-center gap-3 pl-2 border-l">
                  <span className="text-sm font-semibold text-slate-700">
                    {user?.nama}
                  </span>

                  <button
                    onClick={handleLogout}
                    className="text-sm text-red-500 hover:text-red-600 transition"
                  >
                    Logout
                  </button>
                </div>
              </>
            ) : (
              <button
                onClick={() => setAuthOpen(true)}
                className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition"
              >
                Masuk / Daftar
              </button>
            )}
          </div>

        </div>
      </nav>

      {/* MODAL */}
      <AuthModal
        open={authOpen}
        onClose={() => setAuthOpen(false)}
      />
    </>
  );
}
