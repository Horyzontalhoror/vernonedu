export default function ScheduleCard({ schedule }) {
  if (!schedule) return null;

  return (
    <div className="border-t py-4">
      <h3 className="font-semibold text-base text-slate-900">
        {schedule.sub_program?.name || "Kelas"}
        <span className="text-gray-500 font-normal">
          {" "} - {schedule.status || "Unknown"}
        </span>
      </h3>

      <span className="text-gray-500 font-normal">
        {" "}
        {schedule.tanggal
          ? new Date(schedule.tanggal).toLocaleDateString("id-ID", {
              day: "numeric",
              month: "long",
              year: "numeric",
            })
          : "Tanggal belum tersedia"}
      </span>

      <p className="text-gray-600 mt-2 text-sm">
        {schedule.waktu_mulai && schedule.waktu_selesai
          ? `🕒 ${schedule.waktu_mulai.slice(0,5)} - ${schedule.waktu_selesai.slice(0,5)}`
          : "🕒 Waktu belum tersedia"}
      </p>

      <p className="text-gray-500 text-sm">
        📍 {schedule.lokasi || "Lokasi belum tersedia"}
      </p>
    </div>
  );
}
