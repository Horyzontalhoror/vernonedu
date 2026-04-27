export default function CalendarGrid({ jadwals, onSelectDate }) {

  const days = Array.from({ length: 31 }, (_, i) => i + 1);

  const jadwalDates = jadwals.map(j =>
    new Date(j.tanggal).getDate()
  );

  return (
    <div className="p-6 border-r w-80">

      <div className="grid grid-cols-7 text-center text-gray-500 mb-4">
        <span>S</span><span>M</span><span>T</span>
        <span>W</span><span>T</span><span>F</span><span>S</span>
      </div>

      <div className="grid grid-cols-7 gap-2">

        {days.map((day, i) => {
          const hasEvent = jadwalDates.includes(day);

          return (
            <div
              key={i}
              onClick={() => onSelectDate(day)}
              className={`p-2 text-center rounded-full cursor-pointer
                ${hasEvent ? "bg-blue-400 text-white" : "hover:bg-gray-100"}
              `}
            >
              {day}
            </div>
          );
        })}

      </div>
    </div>
  );
}
