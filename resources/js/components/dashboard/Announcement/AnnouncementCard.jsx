import { useState } from "react";

import {
  ChevronDown,
  ChevronUp,
  Megaphone,
} from "lucide-react";

export default function AnnouncementCard({ data }) {

  const [open, setOpen] = useState(false);

  return (

    <div
      className={`overflow-hidden rounded-3xl border p-6 shadow-sm transition duration-300 ${
        data.highlight
          ? "border-[#D8BEE8] bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5]"
          : "border-[#E8D9F0] bg-white hover:shadow-md"
      }`}
    >

      {/* TOP */}
      <div className="flex items-start justify-between gap-4">

        <div className="flex gap-4">

          {/* ICON */}
          <div
            className={`flex h-12 w-12 items-center justify-center rounded-2xl ${
              data.highlight
                ? "bg-white/70"
                : "bg-[#F4ECF9]"
            }`}
          >

            <Megaphone className="h-6 w-6 text-[#7A5C92]" />

          </div>

          {/* CONTENT */}
          <div>

            <h3 className="text-lg font-bold text-gray-800">

              {data.title}

            </h3>

            {/* SHORT MESSAGE */}
            <p className="mt-2 line-clamp-2 text-sm leading-relaxed text-gray-600">

              {data.message}

            </p>

            {/* TIME */}
            <p className="mt-3 text-xs text-gray-400">

              {data.time}

            </p>

          </div>

        </div>

        {/* BUTTON DETAIL */}
        <button
          onClick={() => setOpen(!open)}
          className="flex items-center gap-1 rounded-xl bg-white/70 px-4 py-2 text-sm font-medium text-[#7A5C92] transition hover:bg-white"
        >

          {open ? "Tutup" : "Detail"}

          {open ? (
            <ChevronUp className="h-4 w-4" />
          ) : (
            <ChevronDown className="h-4 w-4" />
          )}

        </button>

      </div>

      {/* DETAIL */}
      {open && (

        <div className="mt-6 rounded-2xl border border-white/50 bg-white/60 p-5 backdrop-blur">

          <h4 className="mb-3 text-sm font-semibold uppercase tracking-wide text-[#7A5C92]">

            Detail Pengumuman

          </h4>

          <div className="space-y-3 text-sm leading-relaxed text-gray-700">

            <p>

              {data.message}

            </p>

            {/* OPTIONAL EXTRA CONTENT */}
            {data.detail && (

              <p>

                {data.detail}

              </p>

            )}

          </div>

        </div>

      )}

    </div>

  );

}
