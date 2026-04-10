import { Link } from "react-router-dom";

export default function Sidebar(){

  return(

    <div className="w-64 bg-white shadow p-6">

      <h2 className="font-bold text-lg mb-6">
        Dashboard
      </h2>

      <div className="flex flex-col gap-4">

        <Link to="/dashboard">
          My Course
        </Link>

        <Link to="/dashboard/calendar">
          My Calendar
        </Link>

        <Link to="/dashboard/certificate">
          My Certificate
        </Link>

        <Link to="/dashboard/announcement">
          Announcement
        </Link>

      </div>

    </div>

  )
}