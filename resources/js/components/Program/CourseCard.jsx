export default function CourseCard({ title, slug, description, usia, isActive = false, onSelect }) {
  const handleSelect = () => {
    if (typeof onSelect === 'function') {
      onSelect(slug);
    }
  };

  return (
    <button
      type="button"
      onClick={handleSelect}
      className={`relative flex h-full w-full flex-col gap-3 rounded-2xl border px-4 pb-5 pt-4 text-left transition ${
        isActive
          ? 'border-purple-500 bg-white shadow-xl ring-2 ring-purple-100'
          : 'border-transparent bg-white hover:-translate-y-0.5 hover:shadow-md'
      }`}
      aria-pressed={isActive}
    >
      <div className="h-36 w-full rounded-xl bg-gradient-to-br from-slate-100 to-slate-200" />

      <div>
        <p className="text-xs font-semibold uppercase tracking-wide text-purple-500">{usia ? `Usia ${usia}` : 'Sub Program'}</p>
        <h3 className="mt-1 text-lg font-semibold text-slate-900">{title}</h3>
        <p className="mt-2 text-sm text-slate-600 line-clamp-3">
          {description || 'Kelas ini dirancang untuk meningkatkan kemampuan peserta secara menyeluruh.'}
        </p>
      </div>

      <span className="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-purple-600">
        Lihat Detail
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          strokeWidth={1.5}
          stroke="currentColor"
          className="h-4 w-4"
        >
          <path strokeLinecap="round" strokeLinejoin="round" d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
        </svg>
      </span>
    </button>
  );
}
