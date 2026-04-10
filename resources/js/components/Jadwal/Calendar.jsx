import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import idLocale from "@fullcalendar/core/locales/id";

export default function Calendar({ events = [], onEventClick }) {
  return (
    <div className="bg-white rounded-xl shadow p-4">
      <FullCalendar
        plugins={[dayGridPlugin, interactionPlugin, timeGridPlugin]}
        initialView="dayGridMonth"
        height={500}
        locale={idLocale}

        headerToolbar={{
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridDay",
        }}

        events={events}

        eventTimeFormat={{
          hour: "2-digit",
          minute: "2-digit",
          hour12: false,
        }}

        // ✅ klik event (pakai extendedProps dari backend)
        eventClick={(info) => {
          info.jsEvent.preventDefault();

          const tanggal =
            info.event.extendedProps?.tanggal ||
            info.event.startStr.split("T")[0];

          if (onEventClick) {
            onEventClick(tanggal);
          }
        }}

        // ✅ klik tanggal kosong
        dateClick={(info) => {
          if (onEventClick) {
            onEventClick(info.dateStr);
          }
        }}
      />
    </div>
  );
}
