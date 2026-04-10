import CalendarGrid from "../../../components/dashboard/Calendar/CalendarGrid";
import ScheduleDetail from "../../../components/dashboard/Calendar/ScheduleDetail";

export default function MyCalendar(){

  return(

    <div>

      <h1 className="text-2xl font-bold">
        My Calendar
      </h1>

      <div className="flex items-center gap-4 mt-6">

        <button className="bg-orange-400 text-white px-4 py-2 rounded-lg">
          TODAY
        </button>

        <span className="text-gray-600">
          October 2025
        </span>

      </div>

      <div className="mt-6 bg-white rounded-xl shadow border border-purple-200 flex">

        <CalendarGrid/>

        <ScheduleDetail/>

      </div>

    </div>

  )
}