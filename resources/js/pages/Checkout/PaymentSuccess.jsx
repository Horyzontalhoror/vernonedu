import { motion } from "framer-motion";
import { useNavigate } from "react-router-dom";

export default function PaymentSuccess() {

    const navigate = useNavigate();

    return (

        <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#F9F5FC] via-white to-[#F4ECF9] p-6">

            <motion.div

                initial={{
                    opacity: 0,
                    y: 30,
                    scale: 0.95,
                }}

                animate={{
                    opacity: 1,
                    y: 0,
                    scale: 1,
                }}

                className="w-full max-w-xl rounded-[32px] border border-[#E8D9F0] bg-white p-10 text-center shadow-2xl"

            >

                {/* ICON */}
                <div className="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-[#EDE0F5]">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={2}
                        stroke="currentColor"
                        className="h-12 w-12 text-[#7A5C92]"
                    >

                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="m4.5 12.75 6 6 9-13.5"
                        />

                    </svg>

                </div>

                {/* TITLE */}
                <h1 className="mt-8 text-3xl font-bold text-gray-800">

                    Pembayaran Berhasil

                </h1>

                {/* DESC */}
                <p className="mt-4 text-sm leading-relaxed text-gray-500">

                    Pembayaran Anda telah berhasil diproses.
                    VernonEdu akan melakukan verifikasi pembayaran
                    sebelum kelas diaktifkan.

                </p>

                {/* INFO */}
                <div className="mt-8 rounded-3xl border border-[#E8D9F0] bg-[#FCFAFD] p-6 text-left">

                    <h3 className="font-semibold text-gray-800">

                        Informasi Selanjutnya

                    </h3>

                    <ul className="mt-4 space-y-3 text-sm text-gray-500">

                        <li>
                            • Tunggu admin melakukan verifikasi pembayaran
                        </li>

                        <li>
                            • Course otomatis muncul setelah pembayaran dikonfirmasi
                        </li>

                        <li>
                            • Anda akan menerima notifikasi ketika kelas aktif
                        </li>

                        <li>
                            • Pastikan email dan notifikasi VernonEdu aktif
                        </li>

                    </ul>

                </div>

                {/* BUTTON */}
                <div className="mt-10 flex flex-col gap-4 sm:flex-row">

                    <button
                        onClick={() => navigate("/")}
                        className="flex-1 rounded-2xl bg-[#7A5C92] px-6 py-4 text-sm font-semibold text-white shadow-lg transition hover:opacity-90"
                    >

                        Kembali ke Home

                    </button>

                    <button
                        onClick={() => navigate("/dashboard")}
                        className="flex-1 rounded-2xl border border-[#E8D9F0] bg-white px-6 py-4 text-sm font-semibold text-gray-700 transition hover:bg-[#FAF7FC]"
                    >

                        Buka Dashboard

                    </button>

                </div>

            </motion.div>

        </div>

    );
}
