export default function CourseCard({
  title,
  slug,
  description,
  usia,
  harga,
  image_url,
  isActive = false,
  onSelect,
}) {

  const handleSelect = () => {

    if (typeof onSelect === "function") {
      onSelect(slug);
    }

  };

  return (

    <button
      type="button"
      onClick={handleSelect}
      aria-pressed={isActive}
      className={`relative flex h-full w-full flex-col overflow-hidden rounded-2xl border bg-white text-left transition ${
        isActive
          ? "border-purple-500 shadow-xl ring-2 ring-purple-100"
          : "border-slate-200 hover:-translate-y-0.5 hover:shadow-lg"
      }`}
    >

      {/* IMAGE */}
      <div className="h-48 w-full overflow-hidden bg-slate-100">

        <img
          src={
            image_url ||
            "https://dummyimage.com/600x400/e5e7eb/6b7280.jpg&text=Sub+Program"
          }
          alt={title}
          className="h-full w-full object-cover transition duration-300 hover:scale-105"
        />

      </div>

      {/* CONTENT */}
      <div className="flex flex-1 flex-col p-5">

        {/* Badge */}
        <p className="text-xs font-semibold uppercase tracking-wide text-purple-500">

          {usia
            ? `Usia ${usia}`
            : "Sub Program"}

        </p>

        {/* Title */}
        <h3 className="mt-2 text-lg font-semibold text-slate-900 line-clamp-2">
          {title}
        </h3>

        {/* Description */}
        <p className="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">

          {description ||
            "Kelas ini dirancang untuk meningkatkan kemampuan peserta secara menyeluruh."}

        </p>

        {/* Footer */}
        <div className="mt-auto pt-5">

          {/* Harga */}
          <div className="mb-4">

            <p className="text-xs text-slate-400">
              Harga
            </p>

            <p className="text-lg font-bold text-purple-600">

              {harga
                ? `Rp ${Number(harga).toLocaleString("id-ID")}`
                : "Gratis"}

            </p>

          </div>

          {/* CTA */}
          <span className="inline-flex items-center gap-2 text-sm font-semibold text-purple-600">

            Lihat Detail

            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              strokeWidth={1.5}
              stroke="currentColor"
              className="h-4 w-4"
            >

              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M17.25 8.25L21 12l-3.75 3.75M21 12H3"
              />

            </svg>

          </span>

        </div>

      </div>

    </button>

  );
}
