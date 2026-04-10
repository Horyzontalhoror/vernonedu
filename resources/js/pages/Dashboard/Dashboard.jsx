import TopBar from "../../components/TopBar";
import AnnouncementBar from "../../components/AnnouncementBar";
import Navbar from "../../components/Navbar";
import { Outlet } from "react-router-dom";
import Sidebar from "../../components/dashboard/Sidebar";
import Footer from "../../components/Footer";

export default function Dashboard({ user }) {

  return (
    <div className="min-h-screen bg-gray-50">

      {/* Header */}
      <TopBar />
      <AnnouncementBar />

      {/* 🔥 kirim user ke navbar */}
      <Navbar user={user} />

      {/* Body */}
      <div className="flex">

        <Sidebar />

        <div className="flex-1 p-10">
          <Outlet />
        </div>

      </div>

      <Footer />

    </div>
  );
}
