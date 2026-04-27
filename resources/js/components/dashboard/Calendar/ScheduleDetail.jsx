export default function ScheduleDetail({ jadwals, selectedDate }) {

  const filtered = jadwals.filter(j =>
    new Date(j.tanggal).getDate() === selectedDate
  );

  if (!selectedDate) {
    return <p className="p-6 text-gray-500">Pilih tanggal</p>;
  }

  if (filtered.length === 0) {
    return <p className="p-6 text-gray-500">Tidak ada jadwal</p>;
  }

  return (
    <div className="p-6 flex-1">

      {filtered.map((item, i) => (
        <div key={i} className="mb-4">

          <h3 className="font-semibold">
            {item.sub_program?.name}
          </h3>

          <p className="text-gray-500">
            ⏰ {item.waktu_mulai} - {item.waktu_selesai}
          </p>

          <p className="text-gray-500">
            📍 {item.lokasi}
          </p>

        </div>
      ))}

    </div>
  );
}
