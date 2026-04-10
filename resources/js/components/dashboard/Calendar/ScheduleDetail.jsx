export default function ScheduleDetail(){

  return(

    <div className="flex flex-1">

      {/* date column */}

      <div className="p-6 border-r w-24 text-center">

        <div className="text-gray-500">
          Fri
        </div>

        <div className="text-4xl font-bold mt-2">
          24
        </div>

      </div>

      {/* schedule */}

      <div className="p-6 flex-1">

        <h3 className="font-semibold">

          Entrepreneurship
          <span className="text-gray-500">
            {" "}– Business Creation
          </span>

        </h3>

        <p className="text-gray-500 mt-4">
          ⏰ 09:00 - 11:00
        </p>

        <p className="text-gray-500 mt-2">
          📍 VernonEdu Campus Sutoyo - Ruang A
        </p>

      </div>

    </div>

  )
}