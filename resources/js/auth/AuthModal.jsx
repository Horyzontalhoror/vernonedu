import { useState } from "react";
import { useNavigate } from "react-router-dom";

import img from "../components/Home/assets/h1.png";
import logo from "../components/assets/Logo Transparant.png";

export default function AuthModal({ open, onClose }) {
  const navigate = useNavigate();

  const [tab, setTab] = useState("login");
  const [loading, setLoading] = useState(false);

  const [loginData, setLoginData] = useState({
    no_telepon: "",
    password: "",
  });

  const [registerData, setRegisterData] = useState({
    nama: "",
    no_telepon: "",
    password: "",
    password_confirmation: "",
  });

  // ================= LOGIN =================
  const handleLogin = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const res = await fetch("http://localhost:8000/api/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(loginData),
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        alert(data.message || "Login gagal");
        setLoading(false);
        return;
      }

      // simpan token
      localStorage.setItem("token", data.token);

      alert("Login berhasil");

      onClose();
      navigate("/dashboard");

    } catch (err) {
      console.error(err);
      alert("Terjadi error");
    } finally {
      setLoading(false);
    }
  };

  // ================= REGISTER =================
  const handleRegister = async (e) => {
    e.preventDefault();

    if (registerData.password !== registerData.password_confirmation) {
      alert("Password tidak sama");
      return;
    }

    setLoading(true);

    try {
      const res = await fetch("http://localhost:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(registerData),
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        alert(data.message || "Register gagal");
        setLoading(false);
        return;
      }

      alert("Register berhasil, tunggu validasi admin");
      setTab("login");

    } catch (err) {
      console.error(err);
      alert("Terjadi error");
    } finally {
      setLoading(false);
    }
  };

  if (!open) return null;

  return (
    <div className="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div className="bg-white rounded-xl shadow-lg grid md:grid-cols-2 overflow-hidden w-[900px]">

        {/* LEFT */}
        <div className="relative hidden md:block">
          <img src={img} className="h-full w-full object-cover" />
          <img
            src={logo}
            alt="Logo"
            className="absolute top-4 left-4 h-10 object-contain"
          />
        </div>

        {/* RIGHT */}
        <div className="p-10 relative">

          <button
            onClick={onClose}
            className="absolute right-6 top-4 text-gray-500"
          >
            ✕
          </button>

          {/* TAB */}
          <div className="flex justify-between border-b pb-3 mb-6">
            <button
              onClick={() => setTab("login")}
              className={tab === "login" ? "text-blue-500 font-semibold" : ""}
            >
              Masuk
            </button>

            <button
              onClick={() => setTab("register")}
              className={tab === "register" ? "text-blue-500 font-semibold" : ""}
            >
              Daftar
            </button>
          </div>

          {/* LOGIN */}
          {tab === "login" && (
            <form onSubmit={handleLogin} className="space-y-4">
              <h2 className="text-xl font-bold">
                Masuk ke akun VernonEdu
              </h2>

              <input
                type="tel"
                placeholder="Masukkan nomor telepon"
                className="w-full border rounded-lg p-3"
                value={loginData.no_telepon}
                onChange={(e) =>
                  setLoginData({
                    ...loginData,
                    no_telepon: e.target.value,
                  })
                }
              />

              <input
                type="password"
                placeholder="Masukkan kata sandi"
                className="w-full border rounded-lg p-3"
                value={loginData.password}
                onChange={(e) =>
                  setLoginData({
                    ...loginData,
                    password: e.target.value,
                  })
                }
              />

              <button
                type="submit"
                disabled={loading}
                className="w-full bg-blue-400 text-white py-3 rounded-lg disabled:opacity-50"
              >
                {loading ? "Loading..." : "Masuk"}
              </button>
            </form>
          )}

          {/* REGISTER */}
          {tab === "register" && (
            <form onSubmit={handleRegister} className="space-y-4">
              <h2 className="text-xl font-bold">
                Daftar Akun VernonEdu
              </h2>

              <input
                type="text"
                placeholder="Nama lengkap"
                className="w-full border rounded-lg p-3"
                value={registerData.nama}
                onChange={(e) =>
                  setRegisterData({
                    ...registerData,
                    nama: e.target.value,
                  })
                }
              />

              <input
                type="tel"
                placeholder="Nomor telpon/WA"
                className="w-full border rounded-lg p-3"
                value={registerData.no_telepon}
                onChange={(e) =>
                  setRegisterData({
                    ...registerData,
                    no_telepon: e.target.value,
                  })
                }
              />

              <input
                type="password"
                placeholder="Password"
                className="w-full border rounded-lg p-3"
                value={registerData.password}
                onChange={(e) =>
                  setRegisterData({
                    ...registerData,
                    password: e.target.value,
                  })
                }
              />

              <input
                type="password"
                placeholder="Konfirmasi Password"
                className="w-full border rounded-lg p-3"
                value={registerData.password_confirmation}
                onChange={(e) =>
                  setRegisterData({
                    ...registerData,
                    password_confirmation: e.target.value,
                  })
                }
              />

              <button
                type="submit"
                disabled={loading}
                className="w-full bg-blue-400 text-white py-3 rounded-lg disabled:opacity-50"
              >
                {loading ? "Loading..." : "Daftar"}
              </button>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}
