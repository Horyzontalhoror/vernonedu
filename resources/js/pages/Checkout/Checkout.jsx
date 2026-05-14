import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { motion } from "framer-motion";

export default function Checkout() {

  const { id } = useParams();

  const navigate = useNavigate();

  const [program, setProgram] =
    useState(null);

  const [loading, setLoading] =
    useState(true);

  const [loadingPay, setLoadingPay] =
    useState(false);

  const [showMateri, setShowMateri] =
    useState(false);

  /*
  |--------------------------------------------------------------------------
  | FETCH DATA
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    const fetchData = async () => {

      try {

        const res = await fetch(
          `http://localhost:8000/api/sub-programs/${id}`
        );

        if (!res.ok)
          throw new Error(
            "Gagal fetch data"
          );

        const data =
          await res.json();

        setProgram(data);

      } catch (err) {

        console.error(err);

        setProgram(null);

      } finally {

        setLoading(false);

      }
    };

    fetchData();

  }, [id]);

  /*
  |--------------------------------------------------------------------------
  | CHECKOUT
  |--------------------------------------------------------------------------
  */

  const handleCheckout = async () => {

    const token =
      localStorage.getItem("token");

    if (!token) {

      alert(
        "Silakan login terlebih dahulu"
      );

      return;
    }

    setLoadingPay(true);

    try {

      const res = await fetch(

        "http://localhost:8000/api/create-transaction",

        {
          method: "POST",

          headers: {
            "Content-Type":
              "application/json",

            Authorization:
              `Bearer ${token}`,
          },

          body: JSON.stringify({
            sub_program_id:
              program.id,
          }),
        }

      );

      const data =
        await res.json();

      if (!res.ok) {

        alert(
          data.message ||
            "Gagal membuat transaksi"
        );

        return;
      }

      window.snap.pay(
        data.snap_token
      );

    } catch (err) {

      console.error(err);

      alert("Terjadi error");

    } finally {

      setLoadingPay(false);

    }
  };

  /*
  |--------------------------------------------------------------------------
  | LOADING
  |--------------------------------------------------------------------------
  */

  if (loading)

    return (

      <div className="flex min-h-screen items-center justify-center bg-[#FAF7FC]">

        <p className="text-sm text-gray-500">
          Loading...
        </p>

      </div>

    );

  /*
  |--------------------------------------------------------------------------
  | NOT FOUND
  |--------------------------------------------------------------------------
  */

  if (!program)

    return (

      <div className="flex min-h-screen items-center justify-center bg-[#FAF7FC]">

        <p className="text-sm text-red-500">
          Data tidak ditemukan
        </p>

      </div>

    );

  const materis =
    Array.isArray(program.materis)
      ? program.materis
      : [];

  return (

    <div className="min-h-screen bg-gradient-to-br from-[#F9F5FC] via-white to-[#F4ECF9] p-6">

      <div className="mx-auto max-w-6xl">

        <motion.div

          initial={{
            opacity: 0,
            y: 30,
          }}

          animate={{
            opacity: 1,
            y: 0,
          }}

          className="overflow-hidden rounded-[32px] border border-[#E8D9F0] bg-white shadow-xl"

        >

          <div className="grid lg:grid-cols-2">

            {/* LEFT */}
            <div className="p-8 lg:p-10">

              {/* HEADER */}
              <div>

                <p className="text-xs font-semibold uppercase tracking-widest text-[#7A5C92]">

                  Checkout Program

                </p>

                <h1 className="mt-2 text-3xl font-bold text-gray-800">

                  {program.name}

                </h1>

                <p className="mt-4 text-sm leading-relaxed text-gray-500">

                  {program.description ||
                    "Deskripsi program belum tersedia."}

                </p>

              </div>

              {/* INFO */}
              <div className="mt-8 grid gap-4 sm:grid-cols-2">

                <div className="rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] p-5">

                  <p className="text-xs font-medium text-gray-400">

                    Usia

                  </p>

                  <p className="mt-2 text-lg font-bold text-gray-800">

                    {program.usia || "-"}

                  </p>

                </div>

                <div className="rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] p-5">

                  <p className="text-xs font-medium text-gray-400">

                    Total Materi

                  </p>

                  <p className="mt-2 text-lg font-bold text-gray-800">

                    {materis.length} Materi

                  </p>

                </div>

              </div>

              {/* MATERI */}
              <div className="mt-8">

                <button
                  type="button"
                  onClick={() =>
                    setShowMateri(
                      !showMateri
                    )
                  }
                  className="flex w-full items-center justify-between rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] px-5 py-4 transition hover:bg-[#F8F3FB]"
                >

                  <div className="flex items-center gap-3">

                    <h3 className="text-lg font-bold text-gray-800">

                      Materi

                    </h3>

                    <div className="rounded-xl bg-[#EDE0F5] px-3 py-1 text-xs font-semibold text-[#7A5C92]">

                      {materis.length}

                    </div>

                  </div>

                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth={2}
                    stroke="currentColor"
                    className={`h-5 w-5 text-[#7A5C92] transition ${
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

                    {materis.map(
                      (
                        materi,
                        index
                      ) => (

                        <div
                          key={materi.id}
                          className="flex items-start gap-4 rounded-2xl border border-[#E8D9F0] bg-[#FCFAFD] p-5"
                        >

                          <div className="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#EDE0F5] text-sm font-bold text-[#7A5C92]">

                            {index + 1}

                          </div>

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

                      )
                    )}

                  </div>

                )}

              </div>

              {/* BACK */}
              <button
                onClick={() =>
                  navigate(-1)
                }
                className="mt-8 text-sm font-medium text-gray-400 transition hover:text-gray-600"
              >

                ← Kembali

              </button>

            </div>

            {/* RIGHT */}
            <div className="flex flex-col justify-between bg-gradient-to-br from-[#7A5C92] to-[#8B5FB0] p-8 text-white lg:p-10">

              <div>

                <div className="rounded-3xl bg-white/10 p-6 backdrop-blur">

                  <p className="text-sm opacity-80">

                    Total Pembayaran

                  </p>

                  <h2 className="mt-3 text-4xl font-bold">

                    Rp{" "}

                    {Number(
                      program.harga || 0
                    ).toLocaleString(
                      "id-ID"
                    )}

                  </h2>

                </div>

                <div className="mt-8 space-y-4">

                  <div className="rounded-2xl border border-white/10 bg-white/5 p-5">

                    <h3 className="font-semibold">

                      Pembayaran Aman

                    </h3>

                    <p className="mt-2 text-sm leading-relaxed text-white/70">

                      Pembayaran diproses
                      melalui Midtrans dengan
                      metode pembayaran yang
                      aman dan terpercaya.

                    </p>

                  </div>

                  <div className="rounded-2xl border border-white/10 bg-white/5 p-5">

                    <h3 className="font-semibold">

                      Aktivasi Kelas

                    </h3>

                    <p className="mt-2 text-sm leading-relaxed text-white/70">

                      Setelah pembayaran
                      dikonfirmasi admin,
                      kelas akan otomatis
                      muncul di dashboard
                      Anda.

                    </p>

                  </div>

                </div>

              </div>

              {/* CTA */}
              <div className="mt-10">

                <button
                  onClick={
                    handleCheckout
                  }
                  disabled={loadingPay}
                  className="w-full rounded-2xl bg-white py-4 text-sm font-bold text-[#7A5C92] shadow-lg transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50"
                >

                  {loadingPay
                    ? "Memproses..."
                    : "Bayar Sekarang"}

                </button>

                <p className="mt-4 text-center text-xs text-white/60">

                  Dengan melanjutkan,
                  Anda menyetujui syarat
                  dan ketentuan VernonEdu

                </p>

              </div>

            </div>

          </div>

        </motion.div>

      </div>

    </div>
  );
}
