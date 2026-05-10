import { useNavigate } from "react-router-dom";

import {
  ArrowRight,
  BookOpen,
  CheckCircle2,
} from "lucide-react";

export default function CourseProgressCard({
  course,
}) {

  const navigate = useNavigate();

  return (

    <div className="group overflow-hidden rounded-[2rem] border border-[#E8D9F0] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

      <div className="flex flex-col lg:flex-row">

        {/* IMAGE */}
        <div className="relative h-60 w-full overflow-hidden bg-[#F4ECF9] lg:w-80">

          <img
            src={
              course.image_url ||
              "https://dummyimage.com/600x400/e5e7eb/6b7280.jpg&text=Course"
            }
            alt={course.title}
            className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
          />

          {/* OVERLAY */}
          <div className="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent" />

        </div>

        {/* CONTENT */}
        <div className="flex flex-1 flex-col justify-between p-7">

          <div>

            {/* BADGE */}
            <div className="inline-flex items-center gap-2 rounded-2xl bg-[#F4ECF9] px-4 py-2 text-xs font-semibold text-[#7A5C92]">

              <BookOpen className="h-4 w-4" />

              Course Aktif

            </div>

            {/* TITLE */}
            <h3 className="mt-5 text-2xl font-bold text-gray-800">

              {course.title}

            </h3>

            {/* DESCRIPTION */}
            <p className="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-500">

              {course.description}

            </p>

            {/* INFO */}
            <div className="mt-6 flex flex-wrap gap-3">

              <div className="rounded-2xl bg-[#F9F5FC] px-4 py-2 text-xs font-semibold text-[#7A5C92]">

                {course.usia || "Semua Usia"}

              </div>

              <div className="rounded-2xl bg-green-100 px-4 py-2 text-xs font-semibold text-green-700">

                {course.transaction_status || "Aktif"}

              </div>

              <div className="rounded-2xl bg-orange-100 px-4 py-2 text-xs font-semibold text-orange-700">

                Rp{" "}
                {Number(course.harga).toLocaleString(
                  "id-ID"
                )}

              </div>

            </div>

          </div>

          {/* FOOTER */}
          <div className="mt-8">

            {/* TOP */}
            <div className="mb-3 flex items-center justify-between">

              <div>

                <p className="text-sm font-semibold text-gray-700">

                  Progress Belajar

                </p>

                <p className="mt-1 text-xs text-gray-500">

                  {course.materi_selesai}
                  {" / "}
                  {course.total_materi}
                  {" "}materi selesai

                </p>

              </div>

              <div className="rounded-2xl bg-[#F4ECF9] px-4 py-2 text-sm font-bold text-[#7A5C92]">

                {course.progress}%

              </div>

            </div>

            {/* BAR */}
            <div className="h-3 overflow-hidden rounded-full bg-[#EDE0F5]">

              <div
                className="h-full rounded-full bg-[#7A5C92] transition-all duration-500"
                style={{
                  width: `${course.progress}%`,
                }}
              />

            </div>

            {/* ACTION */}
            <div className="mt-6 flex items-center justify-between">

              <div className="flex items-center gap-2 text-sm text-gray-500">

                <CheckCircle2 className="h-4 w-4 text-green-600" />

                Course Sedang Dipelajari

              </div>

              <button
                onClick={() =>
                  navigate(
                    `/dashboard/course/${course.slug}`
                  )
                }
                className="inline-flex items-center gap-2 rounded-2xl bg-[#7A5C92] px-5 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
              >

                Lihat Detail

                <ArrowRight className="h-4 w-4" />

              </button>

            </div>

          </div>

        </div>

      </div>

    </div>

  );
}
