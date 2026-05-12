import { useEffect, useState } from "react";

import {
  Bell,
  CreditCard,
  Award,
  Megaphone,
  CheckCircle2,
} from "lucide-react";

const API_URL =
  import.meta.env.VITE_API_URL;

export default function Notifications() {

  const [notifications, setNotifications] =
    useState([]);

  const [loading, setLoading] =
    useState(true);

  /*
  |--------------------------------------------------------------------------
  | FETCH
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    fetchNotifications();

  }, []);

  const fetchNotifications = async () => {

    try {

      const token =
        localStorage.getItem("token");

      const res = await fetch(

        `${API_URL}/notifications`,

        {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        }
      );

      const data = await res.json();

      setNotifications(data);

    } catch (err) {

      console.error(err);

    } finally {

      setLoading(false);

    }
  };

  /*
  |--------------------------------------------------------------------------
  | READ
  |--------------------------------------------------------------------------
  */

  const markAsRead = async (id) => {

    try {

      const token =
        localStorage.getItem("token");

      await fetch(

        `${API_URL}/notifications/${id}/read`,

        {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        }
      );

      setNotifications((prev) =>
        prev.map((notif) =>
          notif.id === id
            ? {
                ...notif,
                read_at: new Date(),
              }
            : notif
        )
      );

    } catch (err) {

      console.error(err);

    }
  };

  /*
  |--------------------------------------------------------------------------
  | ICON
  |--------------------------------------------------------------------------
  */

  const getNotifIcon = (type) => {

    switch (type) {

      case "payment":
        return (
          <CreditCard className="h-6 w-6 text-green-600" />
        );

      case "certificate":
        return (
          <Award className="h-6 w-6 text-yellow-600" />
        );

      case "announcement":
        return (
          <Megaphone className="h-6 w-6 text-blue-600" />
        );

      default:
        return (
          <Bell className="h-6 w-6 text-[#7A5C92]" />
        );
    }
  };

  return (

    <div className="space-y-8">

      {/* HEADER */}
      <div className="rounded-3xl border border-[#E8D9F0] bg-white p-8 shadow-sm">

        <div className="flex items-center gap-4">

          <div className="flex h-16 w-16 items-center justify-center rounded-3xl bg-[#F4ECF9]">

            <Bell className="h-8 w-8 text-[#7A5C92]" />

          </div>

          <div>

            <h1 className="text-3xl font-bold text-gray-800">

              Notifikasi

            </h1>

            <p className="mt-2 text-sm text-gray-500">

              Semua update terbaru VernonEdu.

            </p>

          </div>

        </div>

      </div>

      {/* CONTENT */}
      <div className="space-y-5">

        {loading ? (

          <div className="rounded-3xl border border-[#E8D9F0] bg-white p-12 text-center shadow-sm">

            <p className="text-gray-500">
              Memuat notifikasi...
            </p>

          </div>

        ) : notifications.length > 0 ? (

          notifications.map((notif) => (

            <button
              key={notif.id}
              onClick={() =>
                markAsRead(notif.id)
              }
              className={`w-full rounded-3xl border p-6 text-left shadow-sm transition hover:shadow-md ${
                !notif.read_at
                  ? "border-[#DCC9EA] bg-[#FCFAFD]"
                  : "border-[#E8D9F0] bg-white"
              }`}
            >

              <div className="flex gap-5">

                {/* ICON */}
                <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F4ECF9]">

                  {getNotifIcon(notif.type)}

                </div>

                {/* CONTENT */}
                <div className="flex-1">

                  <div className="flex items-start justify-between gap-4">

                    <div>

                      <h3 className="text-lg font-bold text-gray-800">

                        {notif.title}

                      </h3>

                      <p className="mt-2 text-sm leading-relaxed text-gray-500">

                        {notif.message}

                      </p>

                    </div>

                    {!notif.read_at && (

                      <span className="mt-2 h-3 w-3 rounded-full bg-[#7A5C92]" />

                    )}

                  </div>

                  {/* FOOTER */}
                  <div className="mt-5 flex items-center gap-2 text-xs text-gray-400">

                    <CheckCircle2 className="h-4 w-4" />

                    {new Date(
                      notif.created_at
                    ).toLocaleString("id-ID")}

                  </div>

                </div>

              </div>

            </button>

          ))

        ) : (

          <div className="rounded-3xl border border-dashed border-[#DCC9EA] bg-white p-16 text-center">

            <Bell className="mx-auto h-12 w-12 text-[#DCC9EA]" />

            <p className="mt-5 text-gray-500">

              Belum ada notifikasi.

            </p>

          </div>

        )}

      </div>

    </div>
  );
}
