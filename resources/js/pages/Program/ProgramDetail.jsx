import { IconBase } from "react-icons";

export default function ProgramDetail({ data, loading, error, onClear }) {
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

        {/* Icon */}
        <div className="flex h-16 w-16 items-center justify-center rounded-full bg-purple-100">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            className="h-8 w-8 text-purple-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            strokeWidth={1.5}
            >
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M12 6v6l4 2M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"
            />
            </svg>
        </div>

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

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
        </svg>

        <span>Pilih dari daftar di sebelah kiri</span>

        </div>

        </aside>
    );
    }

  const materis = Array.isArray(data.materis) ? data.materis : [];

  return (
    <aside className="space-y-6">
      <div className="rounded-2xl bg-gradient-to-br from-purple-100 via-white to-sky-100 p-6 shadow-lg">
        <div className="flex items-start justify-between gap-4">
          <div>
            <p className="text-xs uppercase tracking-wide text-slate-500">
              {data.program?.nama || 'Program tidak tersedia'}
            </p>
            <h2 className="mt-2 text-2xl font-semibold text-slate-900">{data.name}</h2>
            <p className="mt-3 text-sm text-slate-600 leading-relaxed">
              {data.description || 'Deskripsi belum tersedia.'}
            </p>
          </div>
          {onClear && (
            <button
              type="button"
              className="rounded-full border border-slate-300 px-3 py-1 text-xs font-semibold text-slate-600 hover:bg-white"
              onClick={onClear}
            >
              Tutup
            </button>
          )}
        </div>

        <div className="mt-4 flex flex-wrap items-center gap-2 text-xs font-medium">
          <span className="rounded-full bg-white/70 px-3 py-1 text-slate-700">
            Usia {data.usia || '-'}
          </span>
          {/* <span className="rounded-full border border-white/60 px-3 py-1 text-slate-600">
            Slug: {data.slug}
          </span> */}
        </div>
      </div>

      <div className="rounded-2xl border border-slate-100 bg-white p-6 shadow">
        <h3 className="text-lg font-semibold text-slate-900">Detail Program</h3>
        <p className="mt-3 text-sm leading-relaxed text-slate-600">
          {data.program.deskripsi || 'Deskripsi belum tersedia.'}
        </p>
      </div>

      <div className="rounded-2xl border border-slate-100 bg-white p-6 shadow">
        <h3 className="text-lg font-semibold text-slate-900">Biaya Reguler</h3>
        <p className="mt-1 text-sm text-slate-500">Hubungi tim admin untuk penawaran terbaru.</p>
        <button className="mt-4 w-full rounded-xl bg-purple-600 py-2 text-sm font-semibold text-white shadow hover:bg-purple-700">
          Hubungi Admin
        </button>
      </div>

      <div className="rounded-2xl border border-slate-100 bg-white p-6 shadow">
        <h3 className="text-lg font-semibold text-slate-900">Materi Pembelajaran</h3>
        <div className="mt-4 space-y-4">
          {materis.length ? (
            materis.map((item) => (
              <div key={item.id} className="rounded-xl border border-slate-100 bg-slate-50 p-3">
                <p className="text-sm font-semibold text-slate-900">{item.judul}</p>
                {item.deskripsi && (
                  <p className="text-xs text-slate-600">{item.deskripsi}</p>
                )}
              </div>
            ))
          ) : (
            <p className="text-sm text-slate-500">Materi belum tersedia.</p>
          )}
        </div>
      </div>
    </aside>
  );
}
