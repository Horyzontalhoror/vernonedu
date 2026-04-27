import { useEffect, useState } from "react";
import CalendarGrid from "../../../components/dashboard/Calendar/CalendarGrid";
import ScheduleDetail from "../../../components/dashboard/Calendar/ScheduleDetail";

export default function MyCalendar() {
  const [jadwals, setJadwals] = useState([]);
  const [selectedDate, setSelectedDate] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const token = localStorage.getItem("token");

        const res = await fetch("http://localhost:8000/api/my-schedule", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        const data = await res.json();
        setJadwals(data);

      } catch (err) {
        console.error(err);
      }
    };

    fetchData();
  }, []);

  return (
    <div>

      <h1 className="text-2xl font-bold">My Calendar</h1>

      <div className="mt-6 bg-white rounded-xl shadow flex">

        <CalendarGrid
          jadwals={jadwals}
          onSelectDate={setSelectedDate}
        />

        <ScheduleDetail
          jadwals={jadwals}
          selectedDate={selectedDate}
        />

      </div>

    </div>
  );
}
