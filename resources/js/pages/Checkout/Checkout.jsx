import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { motion } from "framer-motion";

export default function Checkout() {

    const { id } = useParams();
    const navigate = useNavigate();
    const [program, setProgram] = useState(null);
    const [loading, setLoading] = useState(true);
    const [loadingPay, setLoadingPay] = useState(false);
    const [showMateri, setShowMateri] = useState(false);
    const [showConfirm, setShowConfirm] = useState(false);
    const [showWarning, setShowWarning] = useState(false);
    const [warningMessage, setWarningMessage] = useState("");

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
                if (!res.ok) throw new Error("Gagal fetch data");
                const data = await res.json();
                setProgram(data);
            } catch (err) {
                console.error(err); setProgram(null);
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

    const handleCheckout = () => {
        const token = localStorage.getItem("token");

        if (!token) {
            setWarningMessage("Silakan login terlebih dahulu");
            setShowWarning(true);
            return;
        }

        setShowConfirm(true);
    };

    const processCheckout = async () => {
        const token = localStorage.getItem("token");

        setShowConfirm(false);
        setLoadingPay(true);

        try {
            const res = await fetch(
                "http://localhost:8000/api/create-transaction",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify({
                        sub_program_id: program.id,
                    }),
                }
            );

            const data = await res.json();

            if (!res.ok) {
                setWarningMessage(
                    data.message || "Gagal membuat transaksi"
                );

                setShowWarning(true);
                return;
            }

            window.snap.pay(data.snap_token, {
                onSuccess: function () {
                    navigate("/payment-success");
                },

                onPending: function () {
                    navigate("/payment-success");
                },

                onError: function () {
                    setWarningMessage(
                        "Pembayaran gagal diproses"
                    );
                    setShowWarning(true);
                },

                onClose: function () {
                    setWarningMessage(
                        "Pembayaran dibatalkan"
                    );
                    setShowWarning(true);
                },
            });

        } catch (err) {
            console.error(err);

            setWarningMessage(
                "Terjadi kesalahan pada sistem"
            );

            setShowWarning(true);
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
        <>
        <div className="min-h-screen bg-gradient-to-br from-[#F9F5FC] via-white to-[#F4ECF9] p-6">
            <div className="mx-auto max-w-6xl">
                <motion.div
                    initial={{ opacity: 0, y: 30, }}
                    animate={{ opacity: 1, y: 0 }}
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
                                        className={`h-5 w-5 text-[#7A5C92] transition ${showMateri
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
                                onClick={() => navigate(-1)}
                                className="mt-8 inline-flex items-center gap-2 rounded-2xl border border-[#E8D9F0] bg-white px-5 py-3 text-sm font-semibold text-gray-600 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#D8BEEA] hover:bg-[#FAF7FC] hover:text-[#7A5C92] hover:shadow-md"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={2}
                                    stroke="currentColor"
                                    className="h-4 w-4"
                                >

                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M15.75 19.5 8.25 12l7.5-7.5"
                                    />

                                </svg>

                                Kembali

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

                                    <div className="mb-6 rounded-2xl border border-yellow-300 bg-yellow-50 p-4 text-sm">
                                        <h3 className="font-semibold text-yellow-800">
                                            Perhatian
                                        </h3>

                                        <ul className="mt-2 list-disc space-y-1 pl-5 text-yellow-700">
                                            <li>
                                                Pastikan program yang dipilih sudah sesuai.
                                            </li>
                                            <li>
                                                Program yang sudah dibeli tidak dapat dibeli kembali.
                                            </li>
                                            <li>
                                                Pembayaran diproses melalui Midtrans.
                                            </li>
                                            <li>
                                                Akses materi akan diberikan setelah pembayaran berhasil diverifikasi.
                                            </li>
                                        </ul>
                                    </div>

                                    <button
                                        onClick={handleCheckout}
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

        {/* MODAL KONFIRMASI */}
        {showConfirm && (
            <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div className="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">

                    <h2 className="text-xl font-bold text-gray-800">
                        Konfirmasi Pembayaran
                    </h2>

                    <p className="mt-4 text-sm text-gray-600">
                        Anda akan membeli program:
                    </p>

                    <div className="mt-4 rounded-2xl bg-[#F8F3FB] p-4">
                        <p className="font-semibold text-[#7A5C92]">
                            {program?.name}
                        </p>

                        <p className="mt-2 text-lg font-bold text-gray-800">
                            Rp{" "}
                            {Number(
                                program?.harga || 0
                            ).toLocaleString("id-ID")}
                        </p>
                    </div>

                    <div className="mt-4 rounded-2xl border border-yellow-300 bg-yellow-50 p-4">
                        <ul className="list-disc space-y-1 pl-5 text-sm text-yellow-700">
                            <li>
                                Pastikan program yang dipilih sudah benar.
                            </li>
                            <li>
                                Program yang sudah dibeli tidak dapat dibeli kembali.
                            </li>
                            <li>
                                Pembayaran diproses melalui Midtrans.
                            </li>
                            <li>
                                Akses materi diberikan setelah pembayaran berhasil.
                            </li>
                        </ul>
                    </div>

                    <div className="mt-6 flex gap-3">
                        <button
                            onClick={() => setShowConfirm(false)}
                            className="flex-1 rounded-2xl border border-gray-300 py-3 font-medium text-gray-700"
                        >
                            Batal
                        </button>

                        <button
                            onClick={processCheckout}
                            className="flex-1 rounded-2xl bg-[#7A5C92] py-3 font-medium text-white"
                        >
                            Lanjutkan
                        </button>
                    </div>

                </div>
            </div>
        )}

        {/* MODAL PERINGATAN */}
        {showWarning && (
            <div
                className="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4"
                onClick={() => setShowWarning(false)}
            >
                <div
                    className="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl"
                    onClick={(e) => e.stopPropagation()}
                >
                    <div className="flex justify-center">
                        <div className="flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="h-8 w-8 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                                />
                            </svg>
                        </div>
                    </div>

                    <h2 className="mt-4 text-center text-xl font-bold text-gray-800">
                        Peringatan
                    </h2>

                    <p className="mt-3 text-center text-gray-600">
                        {warningMessage}
                    </p>

                    <button
                        onClick={() => setShowWarning(false)}
                        className="mt-6 w-full rounded-2xl bg-[#7A5C92] py-3 font-semibold text-white"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        )}
    </>
);
}
