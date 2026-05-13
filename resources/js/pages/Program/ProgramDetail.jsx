import { IconBase } from "react-icons";
import { useNavigate } from "react-router-dom";

export default function ProgramDetail({ data, loading, error, onClear }) {
    const navigate = useNavigate();

  if (loading) {
    return (
      <aside className="rounded-2xl border border-dashed border-slate-200 bg-white/70 p-6 text-center text-sm text-slate-500">
        Memuat detail kelas...
      </aside>
    );
  }

  if (error) {
    return (
      <aside className="rounded-2xl border border-red-200 bg-red-50 p-6 text-center text-sm text-red-600">
        <p>{error}</p>
        {onClear && (
          <button
            type="button"
            className="mt-3 text-xs font-semibold text-red-700 underline"
            onClick={onClear}
          >
            Kembali ke daftar
          </button>
        )}
      </aside>
    );
  }

    if (!data) {
        return (
            <aside className="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">

            {/* Title */}
            <h3 className="mt-4 text-lg font-semibold text-slate-900">
                Belum ada sub program dipilih
            </h3>

            {/* Description */}
            <p className="mt-2 max-w-sm text-sm text-slate-500 leading-relaxed">
                Silakan pilih salah satu sub program pada daftar untuk melihat detail
                kelas, materi pembelajaran, dan informasi lainnya.
            </p>

            {/* Optional hint / CTA */}
            <div className="mt-6 flex items-center gap-2 text-xs text-slate-400">

            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            strokeWidth={1.5}
            stroke="currentColor"
            className="size-6"
            >
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"
            />
            </svg>

            <span>Pilih dari daftar di sebelah kiri</span>

            </div>

            </aside>
        );
    }

  const materis = Array.isArray(data.materis) ? data.materis : [];

    return (
        <aside>
            <div className="rounded-3xl bg-white shadow-lg border border-slate-100 overflow-hidden">

            {/* HEADER / HERO */}
            <div className="bg-gradient-to-br from-purple-500/10 via-white to-sky-500/10 p-6">
                <div className="flex items-start justify-between gap-4">

                <div>
                    <p className="text-xs uppercase tracking-wider text-slate-400">
                    {data.program?.nama || "Program tidak tersedia"}
                    </p>

                    <h2 className="mt-1 text-2xl font-bold text-slate-900">
                    {data.name}
                    </h2>

                    <p className="mt-3 text-sm text-slate-600 leading-relaxed max-w-md">
                    {data.description || "Deskripsi belum tersedia."}
                    </p>
                </div>

                {onClear && (
                    <button
                    type="button"
                    onClick={onClear}
                    className="text-sm text-slate-400 hover:text-red-500 transition"
                    >
                    ✕
                    </button>
                )}
                </div>

                {/* TAG */}
                <div className="mt-5 flex flex-wrap gap-2">
                <span className="rounded-full bg-white shadow px-3 py-1 text-xs font-medium text-slate-700">
                    Usia {data.usia || "-"}
                </span>
                </div>
            </div>

            {/* CONTENT */}
            <div className="p-6 space-y-6">

                {/* DETAIL */}
                <div>
                <h3 className="text-sm font-semibold text-slate-800">
                    Detail Program
                </h3>

                <p className="mt-2 text-sm leading-relaxed text-slate-600">
                    {data.program?.deskripsi || "Deskripsi belum tersedia."}
                </p>
                </div>

                {/* DIVIDER */}
                <div className="border-t"></div>

                {/* CTA SECTION */}
                <div className="flex flex-col gap-3">

                <div className="flex justify-between items-center">
                    <div>
                    <p className="text-xs text-slate-400">
                        Mulai kelas ini
                    </p>
                    <p className="text-lg font-semibold text-slate-900">
                        Ambil Program
                    </p>
                    </div>
                </div>

                <button
                    className="w-full rounded-xl bg-gradient-to-r from-purple-600 to-blue-500 py-3 text-sm font-semibold text-white shadow hover:opacity-90 transition"
                    onClick={() => {
                    const token = localStorage.getItem("token");

                    if (!token) {
                        // 🔥 buka popup login
                        window.dispatchEvent(new Event("open-auth"));
                        return;
                    }

                    navigate(`/checkout/${data.slug}`);
                    }}
                >

                    Pembayaran
                </button>

                <p className="text-xs text-center text-slate-400">
                    Anda akan diarahkan ke halaman pembayaran
                </p>

                </div>
            </div>

            </div>
        </aside>
    );
}
