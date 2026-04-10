import ScheduleCard from "./ScheduleCard";

export default function ScheduleList({ schedules }) {
  if (!schedules || schedules.length === 0) {
    return (
      <div className="col-span-2 bg-white rounded-xl shadow p-6">
        <p className="text-gray-500 text-sm">
          Tidak ada kelas di tanggal ini
        </p>
      </div>
    );
  }

  return (
    <div className="col-span-2 bg-white rounded-xl shadow p-6">
      {schedules.map((schedule) => (
        <ScheduleCard key={schedule.id} schedule={schedule} />
      ))}
    </div>
  );
}
