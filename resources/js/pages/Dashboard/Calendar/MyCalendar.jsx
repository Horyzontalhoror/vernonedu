import { useEffect, useState } from "react";

import Calendar from "../../../components/Jadwal/Calendar";
import ScheduleList from "../../../components/Jadwal/ScheduleList";

export default function MyCalendar() {

  const [events, setEvents] = useState([]);
  const [selectedDate, setSelectedDate] = useState(null);

  useEffect(() => {

    const fetchData = async () => {

      try {

        const token = localStorage.getItem("token");

        const res = await fetch(
          "http://localhost:8000/api/my-schedule",
          {
            headers: {
              Authorization: `Bearer ${token}`,
              Accept: "application/json",
            },
          }
        );

        if (!res.ok) {
          throw new Error("Gagal mengambil data jadwal");
        }

        const data = await res.json();

        // mapping data untuk FullCalendar
        const mapped = data.map((item) => ({
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
              : "blue",
        }));

        setEvents(mapped);

      } catch (err) {

        console.error(err);

      }
    };

    fetchData();

  }, []);

  // filter jadwal berdasarkan tanggal yang dipilih
  const filteredSchedules = selectedDate
    ? events
        .filter(
          (event) =>
            event.extendedProps.tanggal === selectedDate
        )
        .map((event) => ({
          id: event.id,
          ...event.extendedProps,
        }))
    : [];

  return (
    <div className="p-6">

      {/* Header */}
      <div className="mb-6">

        <h1 className="text-2xl font-bold text-gray-800">
          My Calendar
        </h1>

        <p className="mt-1 text-sm text-gray-500">
          Jadwal kelas dan aktivitas Anda
        </p>

      </div>

      {/* Layout */}
      <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {/* Calendar */}
        <div className="lg:col-span-2">

          <Calendar
            events={events}
            onEventClick={(date) =>
              setSelectedDate(date)
            }
          />

        </div>

        {/* Schedule Detail */}
        <div>

          <ScheduleList
            schedules={filteredSchedules}
          />

        </div>

      </div>

    </div>
  );
}
