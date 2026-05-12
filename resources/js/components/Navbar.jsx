import { Link, useNavigate }
from "react-router-dom";
import { useState, useEffect }
from "react";
import { LayoutDashboard, LogOut, User, Bell, CreditCard, Award, Megaphone, CheckCircle2, }
from "lucide-react";
import { useRef }
from "react";
import AuthModal from "../auth/AuthModal";
import echo from "../echo";
import logo from "./assets/Logo Transparant.png";
export default function Navbar({ user }) {
    const [authOpen, setAuthOpen] = useState(false);
    const [isLogin, setIsLogin] = useState(false);
    const navigate = useNavigate();
    const [notifications, setNotifications] = useState([]);
    const [notifOpen, setNotifOpen] = useState(false);
    const [loadingNotif, setLoadingNotif] = useState(false);
    const notifRef = useRef();
    const API_URL = import.meta.env.VITE_API_URL;

	// CHECK LOGIN

    useEffect(() => {
        const token = localStorage.getItem("token");
        setIsLogin(!!token);
    }, [user]);

	// FETCH NOTIFICATION

    useEffect(() => {
        if (!isLogin) {
            return;
        }
        fetchNotifications();
    }, [isLogin]);
    const fetchNotifications = async () => {
        try {
            setLoadingNotif(true);
            const token = localStorage.getItem("token");
            const res = await fetch(`${API_URL}/notifications`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });
            if (!res.ok) {
                throw new Error("Gagal mengambil notification");
            }
            const data = await res.json();
            setNotifications(data);
        } catch (err) {
            console.error(err);
        } finally {
            setLoadingNotif(false);
        }
    };
    useEffect(() => {
        if (!user?.id) {
            return;
        }
        echo.channel(`notifications.${user.id}`).listen(
            ".notification.created",
            (e) => {
                setNotifications((prev) => [e, ...prev]);
            }
        );
        return () => {
            echo.leave(`notifications.${user.id}`);
        };
    }, [user]);

	// CLOSE DROPDOWN

    useEffect(() => {
        const handleClickOutside = (e) => {
            if (notifRef.current && !notifRef.current.contains(e.target)) {
                setNotifOpen(false);
            }
        };
        document.addEventListener("mousedown", handleClickOutside);
        return () =>
            document.removeEventListener("mousedown", handleClickOutside);
    }, []);

	// MARK AS READ

    const markAsRead = async (id) => {
        try {
            const token = localStorage.getItem("token");
            await fetch(`${API_URL}/notifications/${id}/read`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });
            setNotifications((prev) =>
                prev.map((notif) =>
                    notif.id === id
                        ? {
                              ...notif,
                              read_at: new Date(),
                          }
                        : notif
                )
            );
        } catch (err) {
            console.error(err);
        }
    };
    const unreadCount = notifications.filter((notif) => !notif.read_at).length;
    const getNotifIcon = (type) => {
        switch (type) {
            case "payment":
                return <CreditCard className="h-5 w-5 text-green-600" />;
            case "certificate":
                return <Award className="h-5 w-5 text-yellow-600" />;
            case "announcement":
                return <Megaphone className="h-5 w-5 text-blue-600" />;
            default:
                return <Bell className="h-5 w-5 text-[#7A5C92]" />;
        }
    };
	// LOGOUT

    const handleLogout = () => {
        localStorage.removeItem("token");
        setIsLogin(false);
        navigate("/");
    };
    return (
        <>
            {" "}
            <nav className="sticky top-0 z-50 border-b border-[#E8D9F0] bg-white/80 backdrop-blur-xl">
                <div className="mx-auto flex max-w-screen-xl items-center justify-between px-6 py-4 lg:px-10">
                    {" "}
                    {/* LOGO */}{" "}
                    <div
                        onClick={() => navigate("/")}
                        className="flex cursor-pointer items-center gap-3"
                    >
                        {" "}
                        <img
                            src={logo}
                            alt="Logo"
                            className="h-11 object-contain"
                        />{" "}
                    </div>{" "}
                    {/* MENU */}{" "}
                    <div className="hidden items-center gap-8 md:flex">
                        {" "}
                        <Link
                            className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
                            to="/"
                        >
                            {" "}
                            Home{" "}
                        </Link>{" "}
                        <Link
                            className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
                            to="/program"
                        >
                            {" "}
                            Program{" "}
                        </Link>{" "}
                        <Link
                            className="text-sm font-semibold text-gray-700 transition hover:text-[#7A5C92]"
                            to="/jadwal"
                        >
                            {" "}
                            Jadwal{" "}
                        </Link>{" "}
                    </div>{" "}
                    {/* RIGHT SIDE */}{" "}
                    <div className="flex items-center gap-4">
                        {" "}
                        {isLogin ? (
                            <>
                                {" "}
                                {/* NOTIFICATION */}{" "}
                                <div className="relative" ref={notifRef}>
                                    {" "}
                                    <button
                                        onClick={() => setNotifOpen(!notifOpen)}
                                        className="relative flex h-12 w-12 items-center justify-center rounded-2xl border border-[#E8D9F0] bg-white transition hover:bg-[#F9F5FC]"
                                    >
                                        <Bell className="h-5 w-5 text-[#7A5C92]" />{" "}
                                        {unreadCount > 0 && (
                                            <span className="absolute -right-1 -top-1 flex h-6 min-w-[24px] items-center justify-center rounded-full bg-red-500 px-1 text-xs font-bold text-white">
                                                {" "}
                                                {unreadCount}{" "}
                                            </span>
                                        )}{" "}
                                    </button>{" "}
                                    {/* DROPDOWN */}{" "}
                                    {notifOpen && (
                                        <div className="absolute right-0 mt-4 w-[380px] overflow-hidden rounded-3xl border border-[#E8D9F0] bg-white shadow-2xl">
                                            {" "}
                                            {/* HEADER */}{" "}
                                            <div className="border-b border-[#F4ECF9] bg-[#FCFAFD] px-6 py-5">
                                                <h3 className="text-lg font-bold text-gray-800">
                                                    Notifikasi{" "}
                                                </h3>{" "}
                                                <p className="mt-1 text-xs text-gray-500">
                                                    {" "}
                                                    Update terbaru VernonEdu{" "}
                                                </p>
                                            </div>{" "}
                                            {/* LIST */}{" "}
                                            <div className="max-h-[420px] overflow-y-auto">
                                                {" "}
                                                {loadingNotif ? (
                                                    <div className="p-10 text-center text-sm text-gray-500">
                                                        Memuat notifikasi...{" "}
                                                    </div>
                                                ) : notifications.length > 0 ? (
                                                    notifications.map(
                                                        (notif) => (
                                                            <button
                                                                key={notif.id}
                                                                onClick={() =>
                                                                    markAsRead(
                                                                        notif.id
                                                                    )
                                                                }
                                                                className={`w-full border-b border-[#F8F4FB] p-5 text-left transition hover:bg-[#FCFAFD] ${
                                                                    !notif.read_at
                                                                        ? "bg-[#FAF7FC]"
                                                                        : "bg-white"
                                                                }`}
                                                            >
                                                                {" "}
                                                                <div className="flex gap-4">
                                                                    {" "}
                                                                    {/* ICON */}{" "}
                                                                    <div className="mt-1 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#F4ECF9]">
                                                                        {" "}
                                                                        {getNotifIcon(
                                                                            notif.type
                                                                        )}{" "}
                                                                    </div>{" "}
                                                                    {/* CONTENT */}{" "}
                                                                    <div className="flex-1">
                                                                        {" "}
                                                                        <div className="flex items-start justify-between gap-3">
                                                                            {" "}
                                                                            <h4 className="text-sm font-bold text-gray-800">
                                                                                {" "}
                                                                                {
                                                                                    notif.title
                                                                                }{" "}
                                                                            </h4>{" "}
                                                                            {!notif.read_at && (
                                                                                <span className="mt-1 h-2.5 w-2.5 rounded-full bg-[#7A5C92]" />
                                                                            )}{" "}
                                                                        </div>{" "}
                                                                        <p className="mt-2 text-sm leading-relaxed text-gray-500">
                                                                            {" "}
                                                                            {
                                                                                notif.message
                                                                            }{" "}
                                                                        </p>{" "}
                                                                        <div className="mt-3 flex items-center gap-2 text-xs text-gray-400">
                                                                            {" "}
                                                                            <CheckCircle2 className="h-3.5 w-3.5" />{" "}
                                                                            {new Date(
                                                                                notif.created_at
                                                                            ).toLocaleString(
                                                                                "id-ID"
                                                                            )}{" "}
                                                                        </div>{" "}
                                                                    </div>{" "}
                                                                </div>{" "}
                                                            </button>
                                                        )
                                                    )
                                                ) : (
                                                    <div className="p-12 text-center">
                                                        {" "}
                                                        <Bell className="mx-auto h-10 w-10 text-[#D8C7E5]" />{" "}
                                                        <p className="mt-4 text-sm font-medium text-gray-500">
                                                            Belum ada notifikasi{" "}
                                                        </p>{" "}
                                                    </div>
                                                )}{" "}
                                            </div>{" "}
                                        </div>
                                    )}{" "}
                                </div>{" "}
                                {/* DASHBOARD */}{" "}
                                <button
                                    onClick={() => navigate("/dashboard")}
                                    className="flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] px-5 py-3 text-sm font-semibold text-[#7A5C92] shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md"
                                >
                                    <LayoutDashboard className="h-4 w-4" />{" "}
                                    Dashboard{" "}
                                </button>{" "}
                                {/* USER */}{" "}
                                <div className="flex items-center gap-3 border-l border-[#E8D9F0] pl-4">
                                    {" "}
                                    {/* AVATAR */}{" "}
                                    <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#F4ECF9]">
                                        {" "}
                                        <User className="h-5 w-5 text-[#7A5C92]" />{" "}
                                    </div>{" "}
                                    {/* INFO */}{" "}
                                    <div className="hidden sm:block">
                                        {" "}
                                        <p className="text-sm font-semibold text-gray-800">
                                            {" "}
                                            {user?.nama || "User"}{" "}
                                        </p>{" "}
                                        <p className="text-xs text-gray-500">
                                            {" "}
                                            VernonEdu Member{" "}
                                        </p>{" "}
                                    </div>{" "}
                                    {/* LOGOUT */}{" "}
                                    <button
                                        onClick={handleLogout}
                                        className="flex items-center gap-1 rounded-xl px-3 py-2 text-sm font-medium text-red-500 transition hover:bg-red-50 hover:text-red-600"
                                    >
                                        <LogOut className="h-4 w-4" /> Logout{" "}
                                    </button>{" "}
                                </div>{" "}
                            </>
                        ) : (
                            <button
                                onClick={() => setAuthOpen(true)}
                                className="rounded-2xl bg-[#7A5C92] px-5 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
                            >
                                Masuk / Daftar{" "}
                            </button>
                        )}{" "}
                    </div>{" "}
                </div>{" "}
            </nav>{" "}
            {/* MODAL */}{" "}
            <AuthModal open={authOpen} onClose={() => setAuthOpen(false)} />{" "}
        </>
    );
}
