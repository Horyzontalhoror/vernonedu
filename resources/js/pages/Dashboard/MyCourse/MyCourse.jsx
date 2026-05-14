import { useEffect, useState } from "react";

import {
  BookOpen,
  GraduationCap,
  Sparkles,
} from "lucide-react";

import CourseProgressCard from "../../../components/dashboard/MyCourse/CourseProgressCard";

export default function MyCourse() {

  const [courses, setCourses] =
    useState([]);

  const [loading, setLoading] =
    useState(true);

  const [error, setError] =
    useState(null);

  /*
  |--------------------------------------------------------------------------
  | FETCH COURSES
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    const fetchCourses = async () => {

      try {

        setLoading(true);

        const token =
          localStorage.getItem("token");

        const res = await fetch(

          "http://localhost:8000/api/my-courses",

          {
            headers: {
              Authorization: `Bearer ${token}`,
              Accept: "application/json",
            },
          }
        );

        if (!res.ok) {

          throw new Error(
            "Gagal mengambil data course"
          );

        }

        const data =
          await res.json();

        setCourses(data);

      } catch (err) {

        console.error(err);

        setError(
          "Tidak dapat memuat course"
        );

      } finally {

        setLoading(false);

      }
    };

    fetchCourses();

  }, []);

  /*
  |--------------------------------------------------------------------------
  | MAIN
  |--------------------------------------------------------------------------
  */

  return (

    <div className="space-y-8">

      {/* HERO */}
      <div className="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] p-8 shadow-sm">

        {/* BG */}
        <div className="absolute -right-10 -top-10 h-44 w-44 rounded-full bg-white/20 blur-3xl" />
        <div className="absolute bottom-0 left-0 h-52 w-52 rounded-full bg-[#DFD0EB]/40 blur-3xl" />

        <div className="relative z-10 flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

          {/* LEFT */}
          <div>

            <div className="inline-flex items-center gap-2 rounded-2xl bg-white/70 px-4 py-2 text-sm font-semibold text-[#7A5C92] backdrop-blur">

              <Sparkles className="h-4 w-4" />

              Dashboard Course

            </div>

            <h1 className="mt-5 text-4xl font-extrabold text-gray-800">

              My Course

            </h1>

            <p className="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600">

              Pantau progress pembelajaran dan lanjutkan
              course yang sedang Anda ikuti di VernonEdu.

            </p>

          </div>

          {/* RIGHT */}
          <div className="grid gap-4 sm:grid-cols-2">

            {/* TOTAL */}
            <div className="rounded-3xl bg-white/70 p-6 shadow-sm backdrop-blur">

              <div className="flex items-center gap-3">

                <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F4ECF9]">

                  <BookOpen className="h-6 w-6 text-[#7A5C92]" />

                </div>

                <div>

                  <p className="text-sm text-gray-500">
                    Total Course
                  </p>

                  <h3 className="text-3xl font-bold text-gray-800">

                    {courses.length}

                  </h3>

                </div>

              </div>

            </div>

            {/* STATUS */}
            <div className="rounded-3xl bg-white/70 p-6 shadow-sm backdrop-blur">

              <div className="flex items-center gap-3">

                <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F4ECF9]">

                  <GraduationCap className="h-6 w-6 text-[#7A5C92]" />

                </div>

                <div>

                  <p className="text-sm text-gray-500">
                    Status Belajar
                  </p>

                  <h3 className="text-xl font-bold text-gray-800">

                    Aktif

                  </h3>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

      {/* CONTENT */}
      <div className="space-y-6">

        {/* LOADING */}
        {loading && (

          <div className="rounded-3xl border border-[#E8D9F0] bg-white p-10 text-center shadow-sm">

            <div className="mx-auto h-12 w-12 animate-spin rounded-full border-4 border-[#E8D9F0] border-t-[#7A5C92]" />

            <p className="mt-5 text-sm text-gray-500">

              Memuat daftar course...

            </p>

          </div>

        )}

        {/* ERROR */}
        {!loading && error && (

          <div className="rounded-3xl border border-red-200 bg-white p-10 text-center shadow-sm">

            <p className="font-medium text-red-500">

              {error}

            </p>

          </div>

        )}

        {/* EMPTY */}
        {!loading &&
        !error &&
        courses.length === 0 && (

        <div className="rounded-3xl border border-dashed border-[#DFD0EB] bg-white p-14 text-center shadow-sm">

            {/* ICON */}
            <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#F4ECF9]">

            <BookOpen className="h-10 w-10 text-[#7A5C92]" />

            </div>

            {/* TITLE */}
            <h3 className="mt-6 text-2xl font-bold text-gray-800">

            Belum Ada Course

            </h3>

            {/* DESCRIPTION */}
            <p className="mx-auto mt-3 max-w-md text-sm leading-relaxed text-gray-500">

            Anda belum memiliki course aktif.
            Silakan daftar program terlebih dahulu
            untuk mulai belajar bersama VernonEdu.

            </p>

            {/* ALERT */}
            <div className="mx-auto mt-8 max-w-2xl rounded-3xl border border-amber-200 bg-amber-50 p-6 text-left">

            <div className="flex items-start gap-4">

                {/* ICON */}
                <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={1.8}
                    stroke="currentColor"
                    className="h-6 w-6 text-amber-600"
                >

                    <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 15.75h.007v.008H12v-.008Z"
                    />

                </svg>

                </div>

                {/* CONTENT */}
                <div>

                <h4 className="text-sm font-bold text-amber-800">

                    Menunggu Konfirmasi Pembayaran?

                </h4>

                <p className="mt-2 text-sm leading-relaxed text-amber-700">

                    Jika Anda sudah melakukan pembayaran,
                    course akan muncul setelah pembayaran
                    dikonfirmasi oleh admin VernonEdu.
                    Proses verifikasi biasanya membutuhkan
                    beberapa saat tergantung metode pembayaran
                    yang digunakan.

                </p>

                <ul className="mt-4 space-y-2 text-sm text-amber-700">

                    <li>
                    • Pastikan pembayaran telah berhasil dilakukan
                    </li>

                    <li>
                    • Tunggu admin melakukan verifikasi pembayaran
                    </li>

                    <li>
                    • Setelah dikonfirmasi, course otomatis muncul di dashboard
                    </li>

                    <li>
                    • Anda juga akan menerima notifikasi ketika kelas aktif
                    </li>

                </ul>

                </div>

            </div>

            </div>

        </div>

        )}

        {/* LIST */}
        {!loading &&
          !error &&
          courses.length > 0 && (

          <div className="grid gap-6">

            {courses.map((course) => (

              <CourseProgressCard
                key={course.id}
                course={course}
              />

            ))}

          </div>

        )}

      </div>

    </div>
  );
}
