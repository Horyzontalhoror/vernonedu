import { useState } from "react";
import img from "../components/Home/assets/h1.png";
import logo from "../components/assets/Logo Transparant.png";
import { useLocation, useNavigate } from "react-router-dom";

export default function AuthModal({ open, onClose }) {
    const navigate = useNavigate();
    const location = useLocation();

    const [tab, setTab] = useState("login");
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});

    // LOGIN: email / no hp
    const [loginData, setLoginData] = useState({
        login: "",
        password: "",
    });

    // REGISTER
    const [registerData, setRegisterData] = useState({
        nama: "",
        email: "",
        no_telepon: "",
        password: "",
        password_confirmation: "",
    });

    const from = location.state?.from?.pathname || "/";

    // ================= LOGIN =================
    const handleLogin = async (e) => {
        e.preventDefault();
        setErrors({});

        if (!loginData.login.trim()) {
            setErrors({ login: "Email atau nomor telepon wajib diisi" });
            return;
        }

        if (!loginData.password.trim()) {
            setErrors({ password: "Password wajib diisi" });
            return;
        }

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
                return;
            }

            localStorage.setItem("token", data.token);

            alert("Login berhasil");
            window.location.reload();
            onClose();
            navigate(from, { replace: true });

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
        setErrors({});

        if (!registerData.nama.trim()) {
            setErrors({ nama: "Nama wajib diisi" });
            return;
        }

        if (!registerData.email.trim()) {
            setErrors({ email: "Email wajib diisi" });
            return;
        }

        if (!registerData.no_telepon.trim()) {
            setErrors({ no_telepon: "Nomor telepon wajib diisi" });
            return;
        }

        if (!registerData.password.trim()) {
            setErrors({ password: "Password wajib diisi" });
            return;
        }

        if (registerData.password !== registerData.password_confirmation) {
            setErrors({ password_confirmation: "Password tidak sama" });
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
                            <h2 className="text-xl font-bold">Masuk ke akun VernonEdu</h2>

                            <div>
                                <input
                                    type="text"
                                    required
                                    placeholder="Email atau nomor telepon"
                                    className="w-full border rounded-lg p-3"
                                    value={loginData.login}
                                    onChange={(e) =>
                                        setLoginData({
                                            ...loginData,
                                            login: e.target.value,
                                        })
                                    }
                                />
                                {errors.login && (
                                    <p className="text-red-500 text-sm">{errors.login}</p>
                                )}
                            </div>

                            <div>
                                <input
                                    type="password"
                                    required
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
                                {errors.password && (
                                    <p className="text-red-500 text-sm">{errors.password}</p>
                                )}
                            </div>

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
                            <h2 className="text-xl font-bold">Daftar Akun VernonEdu</h2>

                            <div>
                                <input
                                    type="text"
                                    required
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
                                {errors.nama && (
                                    <p className="text-red-500 text-sm">{errors.nama}</p>
                                )}
                            </div>

                            <div>
                                <input
                                    type="email"
                                    required
                                    placeholder="Email"
                                    className="w-full border rounded-lg p-3"
                                    value={registerData.email}
                                    onChange={(e) =>
                                        setRegisterData({
                                            ...registerData,
                                            email: e.target.value,
                                        })
                                    }
                                />
                                {errors.email && (
                                    <p className="text-red-500 text-sm">{errors.email}</p>
                                )}
                            </div>

                            <div>
                                <input
                                    type="tel"
                                    required
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
                                {errors.no_telepon && (
                                    <p className="text-red-500 text-sm">{errors.no_telepon}</p>
                                )}
                            </div>

                            <div>
                                <input
                                    type="password"
                                    required
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
                                {errors.password && (
                                    <p className="text-red-500 text-sm">{errors.password}</p>
                                )}
                            </div>

                            <div>
                                <input
                                    type="password"
                                    required
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
                                {errors.password_confirmation && (
                                    <p className="text-red-500 text-sm">
                                        {errors.password_confirmation}
                                    </p>
                                )}
                            </div>

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
