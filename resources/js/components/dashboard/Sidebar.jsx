import { NavLink } from "react-router-dom";

import {
  BookOpen,
  CalendarDays,
  GraduationCap,
  Bell,
  Megaphone,
  User,
  LayoutDashboard,
} from "lucide-react";

export default function Sidebar() {

  const menus = [

    {
      name: "My Course",
      path: "/dashboard",
      icon: BookOpen,
    },

    {
      name: "Calendar",
      path: "/dashboard/calendar",
      icon: CalendarDays,
    },

    {
      name: "Certificate",
      path: "/dashboard/certificate",
      icon: GraduationCap,
    },

    {
      name: "Announcement",
      path: "/dashboard/announcement",
      icon: Bell,
    },

    {
    name: "Notifications",
    path: "/dashboard/notifications",
    icon: Megaphone,
    },

    {
      name: "Profile",
      path: "/dashboard/profile",
      icon: User,
    },

  ];

  return (

    <aside className="flex min-h-screen w-72 flex-col border-r border-[#E8D9F0] bg-gradient-to-b from-[#DFD0EB]/40 via-white to-[#EDE0F5]/40 p-6 shadow-sm">

      {/* HEADER */}
      <div className="mb-10">

        <div className="flex items-center gap-3">

          <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] shadow-sm">

            <LayoutDashboard className="h-6 w-6 text-[#7A5C92]" />

          </div>

          <div>

            <h2 className="text-xl font-bold text-gray-800">

              Dashboard

            </h2>

            <p className="text-sm text-gray-500">

              VernonEdu

            </p>

          </div>

        </div>

      </div>

      {/* MENU */}
      <nav className="flex flex-1 flex-col gap-3">

        {menus.map((menu) => {

          const Icon = menu.icon;

          return (

            <NavLink
              key={menu.path}
              to={menu.path}
              end={menu.path === "/dashboard"}
              className={({ isActive }) =>

                `group flex items-center gap-4 rounded-2xl px-5 py-4 text-sm font-semibold transition duration-300 ${
                  isActive
                    ? "bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] text-[#7A5C92] shadow-sm"
                    : "text-gray-600 hover:bg-white hover:text-[#7A5C92] hover:shadow-sm"
                }`
              }
            >

              <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 shadow-sm transition group-hover:bg-[#F4ECF9]">

                <Icon className="h-5 w-5" />

              </div>

              <span>

                {menu.name}

              </span>

            </NavLink>

          );

        })}

      </nav>

      {/* FOOTER */}
      <div className="mt-10 rounded-3xl border border-[#E8D9F0] bg-white/70 p-5 shadow-sm backdrop-blur">

        <p className="text-sm font-semibold text-[#7A5C92]">

          🎓 Continue Learning

        </p>

        <p className="mt-2 text-xs leading-relaxed text-gray-500">

          Tingkatkan skill dan kemampuanmu bersama VernonEdu.

        </p>

      </div>

    </aside>

  );

}
