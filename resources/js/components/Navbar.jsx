import { Link, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";

import {
  LayoutDashboard,
  LogOut,
  User,
} from "lucide-react";

import AuthModal from "../auth/AuthModal";

import logo from "./assets/Logo Transparant.png";

export default function Navbar({ user }) {

  const [authOpen, setAuthOpen] =
    useState(false);

  const [isLogin, setIsLogin] =
    useState(false);

  const navigate = useNavigate();

  /*
  |--------------------------------------------------------------------------
  | CHECK LOGIN
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    const token =
      localStorage.getItem("token");

    setIsLogin(!!token);

  }, [user]);

  /*
  |--------------------------------------------------------------------------
  | LOGOUT
  |--------------------------------------------------------------------------
  */

  const handleLogout = () => {

    localStorage.removeItem("token");

    setIsLogin(false);

    navigate("/");

  };

  return (

    <>

      <nav className="sticky top-0 z-50 border-b border-[#E8D9F0] bg-white/80 backdrop-blur-xl">

        <div className="mx-auto flex max-w-screen-xl items-center justify-between px-6 py-4 lg:px-10">

          {/* LOGO */}
          <div
            onClick={() => navigate("/")}
            className="flex cursor-pointer items-center gap-3"
          >

            <img
              src={logo}
              alt="Logo"
              className="h-11 object-contain"
            />

          </div>

          {/* MENU */}
          <div className="hidden items-center gap-8 md:flex">

            <Link
              className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
              to="/"
            >

              Home

            </Link>

            <Link
              className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
              to="/program"
            >

              Program

            </Link>

            <Link
              className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
              to="/jadwal"
            >

              Jadwal

            </Link>

          </div>

          {/* RIGHT SIDE */}
          <div className="flex items-center gap-4">

            {isLogin ? (

              <>

                {/* DASHBOARD */}
                <button
                  onClick={() =>
                    navigate("/dashboard")
                  }
                  className="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] px-5 py-3 text-sm font-semibold text-[#7A5C92] shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md"
                >

                  <LayoutDashboard className="h-4 w-4" />

                  Dashboard

                </button>

                {/* USER */}
                <div className="flex items-center gap-3 border-l border-[#E8D9F0] pl-4">

                  {/* AVATAR */}
                  <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#F4ECF9]">

                    <User className="h-5 w-5 text-[#7A5C92]" />

                  </div>

                  {/* INFO */}
                  <div className="hidden sm:block">

                    <p className="text-sm font-semibold text-gray-800">

                      {user?.nama || "User"}

                    </p>

                    <p className="text-xs text-gray-500">

                      VernonEdu Member

                    </p>

                  </div>

                  {/* LOGOUT */}
                  <button
                    onClick={handleLogout}
                    className="flex items-center gap-1 rounded-xl px-3 py-2 text-sm font-medium text-red-500 transition hover:bg-red-50 hover:text-red-600"
                  >

                    <LogOut className="h-4 w-4" />

                    Logout

                  </button>

                </div>

              </>

            ) : (

              <button
                onClick={() =>
                  setAuthOpen(true)
                }
                className="rounded-2xl bg-[#7A5C92] px-5 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
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
        onClose={() =>
          setAuthOpen(false)
        }
      />

    </>

  );

}
