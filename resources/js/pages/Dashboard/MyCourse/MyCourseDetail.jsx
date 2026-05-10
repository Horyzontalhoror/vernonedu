import { useEffect, useState } from "react";

import {
  ArrowLeft,
  CheckCircle2,
  Clock3,
  BookOpen,
} from "lucide-react";

import {
  Link,
  useParams,
} from "react-router-dom";

const API_URL =
  import.meta.env.VITE_API_URL;

export default function MyCourseDetail() {

  const { slug } = useParams();

  const [course, setCourse] =
    useState(null);

  const [loading, setLoading] =
    useState(true);

  const [error, setError] =
    useState(null);

  /*
  |--------------------------------------------------------------------------
  | FETCH DETAIL
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    fetchCourse();

  }, [slug]);

  const fetchCourse = async () => {

    try {

      setLoading(true);

      const token =
        localStorage.getItem("token");

      const res = await fetch(

        `${API_URL}/my-courses/${slug}`,

        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      if (!res.ok) {

        throw new Error(
          "Gagal memuat detail course"
        );

      }

      const data =
        await res.json();

      setCourse(data);

    } catch (err) {

      console.error(err);

      setError(
        "Tidak dapat memuat detail course"
      );

    } finally {

      setLoading(false);

    }
  };

  /*
  |--------------------------------------------------------------------------
  | LOADING
  |--------------------------------------------------------------------------
  */

  if (loading) {

    return (

      <div className="rounded-3xl border border-[#E8D9F0] bg-white p-10 text-center shadow-sm">

        <p className="text-gray-500">

          Memuat progress course...

        </p>

      </div>

    );
  }

  /*
  |--------------------------------------------------------------------------
  | ERROR
  |--------------------------------------------------------------------------
  */

  if (error) {

    return (

      <div className="rounded-3xl border border-red-200 bg-white p-10 text-center shadow-sm">

        <p className="text-red-500">

          {error}

        </p>

      </div>

    );
  }

  /*
  |--------------------------------------------------------------------------
  | MAIN
  |--------------------------------------------------------------------------
  */

  return (

    <div className="space-y-8">

      {/* HEADER */}
      <div className="flex flex-col gap-5 rounded-3xl bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] p-8 shadow-sm lg:flex-row lg:items-center lg:justify-between">

        <div>

          {/* BACK */}
          <Link
            to="/dashboard"
            className="mb-5 inline-flex items-center gap-2 rounded-2xl bg-white/70 px-4 py-2 text-sm font-semibold text-[#7A5C92] transition hover:bg-white"
          >

            <ArrowLeft className="h-4 w-4" />

            Kembali

          </Link>

          {/* TITLE */}
          <h1 className="text-3xl font-bold text-gray-800">

            {course?.title}

          </h1>

          {/* DESC */}
          <p className="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600">

            {course?.description}

          </p>

        </div>

        {/* PROGRESS */}
        <div className="rounded-3xl bg-white/70 p-6 shadow-sm backdrop-blur">

          <p className="text-sm font-semibold text-[#7A5C92]">

            Total Progress

          </p>

          <h2 className="mt-2 text-5xl font-extrabold text-gray-800">

            {course?.progress || 0}%

          </h2>

          {/* BAR */}
          <div className="mt-4 h-3 w-64 overflow-hidden rounded-full bg-[#EDE0F5]">

            <div
              className="h-full rounded-full bg-[#7A5C92] transition-all"
              style={{
                width: `${course?.progress || 0}%`,
              }}
            />

          </div>

          <p className="mt-3 text-sm text-gray-500">

            {course?.materi_selesai || 0}
            {" "}dari{" "}
            {course?.total_materi || 0}
            {" "}materi selesai

          </p>

        </div>

      </div>

      {/* MATERI */}
      <div className="rounded-3xl border border-[#E8D9F0] bg-white p-8 shadow-sm">

        {/* HEADER */}
        <div className="mb-8 flex items-center justify-between">

          <div>

            <h2 className="text-2xl font-bold text-gray-800">

              Progress Materi

            </h2>

            <p className="mt-1 text-sm text-gray-500">

              Pantau progress pembelajaran Anda.

            </p>

          </div>

          <div className="rounded-2xl bg-[#F4ECF9] px-4 py-2 text-sm font-semibold text-[#7A5C92]">

            {course?.total_materi || 0}
            {" "}Materi

          </div>

        </div>

        {/* LIST */}
        <div className="space-y-5">

          {course?.materis?.length > 0 ? (

            course.materis.map((
              materi,
              index
            ) => (

              <div
                key={materi.id}
                className="flex flex-col gap-5 rounded-3xl border border-[#E8D9F0] bg-[#FCFAFD] p-6 transition hover:shadow-sm lg:flex-row lg:items-center lg:justify-between"
              >

                {/* LEFT */}
                <div className="flex items-start gap-5">

                  {/* ICON */}
                  <div
                    className={`flex h-14 w-14 items-center justify-center rounded-2xl ${
                      materi.status === "selesai"
                        ? "bg-green-100"
                        : "bg-[#EDE0F5]"
                    }`}
                  >

                    {materi.status === "selesai" ? (

                      <CheckCircle2 className="h-7 w-7 text-green-600" />

                    ) : (

                      <BookOpen className="h-7 w-7 text-[#7A5C92]" />

                    )}

                  </div>

                  {/* CONTENT */}
                  <div>

                    <p className="text-xs font-semibold uppercase tracking-wide text-[#7A5C92]">

                      Materi {index + 1}

                    </p>

                    <h3 className="mt-1 text-xl font-bold text-gray-800">

                      {materi.judul}

                    </h3>

                    <p className="mt-2 text-sm leading-relaxed text-gray-500">

                      {materi.deskripsi ||
                        "Materi pembelajaran untuk meningkatkan kemampuan peserta."}

                    </p>

                  </div>

                </div>

                {/* RIGHT */}
                <div className="flex flex-col items-start gap-3 lg:items-end">

                  <div
                    className={`inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold ${
                      materi.status === "selesai"
                        ? "bg-green-100 text-green-700"
                        : "bg-yellow-100 text-yellow-700"
                    }`}
                  >

                    {materi.status === "selesai" ? (

                      <CheckCircle2 className="h-4 w-4" />

                    ) : (

                      <Clock3 className="h-4 w-4" />

                    )}

                    {materi.status === "selesai"
                      ? "Selesai"
                      : "Sedang Dipelajari"}

                  </div>

                  <p className="text-xs text-gray-400">

                    {materi.tanggal
                      ? `Update: ${materi.tanggal}`
                      : "Belum ada aktivitas"}

                  </p>

                </div>

              </div>

            ))

          ) : (

            <div className="rounded-3xl border border-dashed border-[#DFD0EB] p-12 text-center">

              <p className="text-gray-500">

                Belum ada materi tersedia.

              </p>

            </div>

          )}

        </div>

      </div>

    </div>

  );
}
