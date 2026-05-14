import { useNavigate } from "react-router-dom";
import { useState } from "react";

export default function ProgramDetail({
  data,
  loading,
  error,
  onClear,
}) {

  const navigate = useNavigate();

  const [showMateri, setShowMateri] =
  useState(false);

  /*
  |--------------------------------------------------------------------------
  | LOADING
  |--------------------------------------------------------------------------
  */

  if (loading) {

    return (

      <aside className="rounded-3xl border border-[#E8D9F0] bg-white p-8 text-center shadow-sm">

        <p className="text-sm text-gray-500">
          Memuat detail kelas...
        </p>

      </aside>

    );
  }

  /*
  |--------------------------------------------------------------------------
  | ERROR
  |--------------------------------------------------------------------------
  */

  if (error) {

    return (

      <aside className="rounded-3xl border border-red-200 bg-red-50 p-8 text-center shadow-sm">

        <p className="text-sm text-red-600">
          {error}
        </p>

        {onClear && (

          <button
            type="button"
            onClick={onClear}
            className="mt-4 text-sm font-semibold text-red-700 hover:underline"
          >

            Kembali

          </button>

        )}

      </aside>

    );
  }

  /*
  |--------------------------------------------------------------------------
  | EMPTY
  |--------------------------------------------------------------------------
  */

  if (!data) {

    return (

      <aside className="flex flex-col items-center justify-center rounded-3xl border border-[#E8D9F0] bg-white p-10 text-center shadow-sm">

        <div className="flex h-20 w-20 items-center justify-center rounded-3xl bg-[#F4ECF9]">

          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={1.5}
            stroke="currentColor"
            className="h-10 w-10 text-[#7A5C92]"
          >

            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"
            />

          </svg>

        </div>

        <h3 className="mt-6 text-xl font-bold text-gray-800">

          Pilih Program

        </h3>

        <p className="mt-2 max-w-sm text-sm leading-relaxed text-gray-500">

          Pilih salah satu sub program untuk melihat detail kelas,
          materi pembelajaran, dan jadwal yang tersedia.

        </p>

      </aside>

    );
  }

  const materis = Array.isArray(data.materis)
    ? data.materis
    : [];

  return (

    <aside>

      <div className="overflow-hidden rounded-3xl border border-[#E8D9F0] bg-white shadow-sm">

        {/* HERO */}
        <div className="bg-gradient-to-br from-[#DFD0EB]/70 via-white to-[#EDE0F5]/70 p-8">

          <div className="flex items-start justify-between gap-4">

            <div>

              <p className="text-xs font-semibold uppercase tracking-widest text-[#7A5C92]">

                {data.program?.nama || "Program"}

              </p>

              <h2 className="mt-2 text-3xl font-bold text-gray-800">

                {data.name}

              </h2>

              <p className="mt-4 max-w-2xl text-sm leading-relaxed text-gray-600">

                {data.description ||
                  "Deskripsi program belum tersedia."}

              </p>

            </div>

            {onClear && (

              <button
                type="button"
                onClick={onClear}
                className="rounded-xl bg-white px-3 py-2 text-sm text-gray-500 shadow-sm transition hover:text-red-500"
              >

                ✕

              </button>

            )}

          </div>

          {/* TAG */}
          <div className="mt-6 flex flex-wrap gap-3">

            <div className="rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm">

              👥 Usia {data.usia || "-"}

            </div>

            <div className="rounded-2xl bg-[#7A5C92] px-4 py-2 text-sm font-semibold text-white shadow-sm">

              Rp {Number(data.harga || 0).toLocaleString("id-ID")}

            </div>

          </div>

        </div>

        {/* CONTENT */}
        <div className="space-y-8 p-8">

          {/* DETAIL */}
          <div>

            <h3 className="text-lg font-bold text-gray-800">

              Tentang Program

            </h3>

            <p className="mt-3 text-sm leading-relaxed text-gray-600">

              {data.program?.deskripsi ||
                "Deskripsi program belum tersedia."}

            </p>

          </div>

        {/* MATERI */}
        <div>

        <button
            type="button"
            onClick={() =>
            setShowMateri(!showMateri)
            }
            className="flex w-full items-center justify-between rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] px-5 py-4 transition hover:bg-[#F8F3FB]"
        >

            <div className="flex items-center gap-3">

            <h3 className="text-lg font-bold text-gray-800">

                Materi Pembelajaran

            </h3>

            <div className="rounded-xl bg-[#EDE0F5] px-3 py-1 text-xs font-semibold text-[#7A5C92]">

                {materis.length} Materi

            </div>

            </div>

            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={2}
            stroke="currentColor"
            className={`h-5 w-5 text-[#7A5C92] transition duration-300 ${
                showMateri
                ? "rotate-180"
                : ""
            }`}
            >

            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"
            />

            </svg>

        </button>

        {showMateri && (

            <div className="mt-5 space-y-4">

            {materis.length > 0 ? (

                materis.map((materi, index) => (

                <div
                    key={materi.id}
                    className="flex items-start gap-4 rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] p-5"
                >

                    {/* NUMBER */}
                    <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#EDE0F5] text-sm font-bold text-[#7A5C92]">

                    {index + 1}

                    </div>

                    {/* CONTENT */}
                    <div>

                    <h4 className="font-semibold text-gray-800">

                        {materi.judul}

                    </h4>

                    <p className="mt-1 text-sm leading-relaxed text-gray-500">

                        {materi.deskripsi ||
                        "Deskripsi materi belum tersedia."}

                    </p>

                    </div>

                </div>

                ))

            ) : (

                <div className="rounded-2xl border border-dashed border-[#E8D9F0] p-8 text-center">

                <p className="text-sm text-gray-500">

                    Materi belum tersedia.

                </p>

                </div>

            )}

            </div>

        )}

        </div>

          {/* CTA */}
          <div className="rounded-3xl border border-[#E8D9F0] bg-[#FCFAFD] p-6">

            <div className="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

              <div>

                <p className="text-sm text-gray-500">

                  Mulai pembelajaran sekarang

                </p>

                <h3 className="mt-1 text-2xl font-bold text-gray-800">

                  Ambil Program Ini

                </h3>

              </div>

              <div className="w-full lg:w-auto">

                <button
                  onClick={() => {

                    const token =
                      localStorage.getItem("token");

                    if (!token) {

                      window.dispatchEvent(
                        new Event("open-auth")
                      );

                      return;
                    }

                    navigate(
                      `/checkout/${data.slug}`
                    );

                  }}
                  className="w-full rounded-2xl bg-[#7A5C92] px-8 py-4 text-sm font-semibold text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
                >

                  Lanjut Pembayaran

                </button>

                <p className="mt-3 text-center text-xs text-gray-400">

                  Anda akan diarahkan ke halaman checkout

                </p>

              </div>

            </div>

          </div>

        </div>

      </div>

    </aside>

  );
}
