import { useEffect, useState } from "react";
import AnnouncementCard from "../../../components/dashboard/Announcement/AnnouncementCard";

export default function Announcement() {

  const [announcements, setAnnouncements] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchAnnouncements = async () => {
      try {
        const res = await fetch("http://localhost:8000/api/announcements");
        const data = await res.json();

        const mapped = data.map(item => ({
          title: item.judul,
          message: item.isi,
          time: formatDate(item.tanggal),

          // 🔥 highlight jika penting
          highlight: item.tipe === "penting",
        }));

        setAnnouncements(mapped);
      } catch (err) {
        console.error(err);
      } finally {
        setLoading(false);
      }
    };

    fetchAnnouncements();
  }, []);

  // helper format tanggal
  const formatDate = (date) => {
    const d = new Date(date);

    return d.toLocaleDateString("id-ID", {
      day: "numeric",
      month: "short",
      year: "numeric",
    });
  };

  return (
    <div>

      <h1 className="text-2xl font-bold">
        Announcement
      </h1>

      <div className="mt-6 space-y-4">

        {loading ? (
          <p className="text-gray-500">Loading...</p>
        ) : announcements.length === 0 ? (
          <p className="text-gray-500">Belum ada pengumuman</p>
        ) : (
          announcements.map((ann, i) => (
            <AnnouncementCard key={i} data={ann} />
          ))
        )}

      </div>

    </div>
  );
}
