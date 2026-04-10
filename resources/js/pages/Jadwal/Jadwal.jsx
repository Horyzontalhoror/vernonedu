import { useEffect, useState } from "react";
import TopBar from "../../components/TopBar";
import AnnouncementBar from "../../components/AnnouncementBar";
import Navbar from "../../components/Navbar";
import Calendar from "../../components/Jadwal/Calendar";
import ScheduleList from "../../components/Jadwal/ScheduleList";
import Footer from "../../components/Footer";

export default function Jadwal() {

  const [events, setEvents] = useState([]);
  const [selectedDate, setSelectedDate] = useState(null);

  // ✅ FETCH DATA
  useEffect(() => {
    fetch(`${import.meta.env.VITE_API_URL}/jadwals`)
      .then(res => res.json())
      .then(data => {

        const mapped = data.map(item => ({
          id: item.id,
          title: item.sub_program?.name || "Kelas",

          start: `${item.tanggal}T${item.waktu_mulai}`,
          end: `${item.tanggal}T${item.waktu_selesai}`,

          extendedProps: {
            tanggal: item.tanggal,
            waktu_mulai: item.waktu_mulai,
            waktu_selesai: item.waktu_selesai,
            lokasi: item.lokasi,
            status: item.status,
            sub_program: item.sub_program,
          },

          // warna event
          color:
            item.status === "batal"
              ? "red"
              : item.status === "selesai"
              ? "gray"
              : "blue"
        }));

        setEvents(mapped);
      })
      .catch(err => console.error(err));
  }, []);

  // ✅ FILTER DI LUAR useEffect
  const filteredSchedules = selectedDate
    ? events
        .filter(e => e.extendedProps.tanggal === selectedDate)
        .map(e => ({
          id: e.id,
          ...e.extendedProps
        }))
    : [];

  return (

    <div className="bg-gray-50 min-h-screen">

      <TopBar/>
      <AnnouncementBar/>
      <Navbar/>

      <div className="grid grid-cols-3 gap-8 px-10 mt-10">

        <Calendar
          events={events}
          onEventClick={(date) => setSelectedDate(date)}
        />

        <ScheduleList schedules={filteredSchedules} />

      </div>

      <Footer/>

    </div>
  );
}
