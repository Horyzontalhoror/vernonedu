import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";

export default function BatchCourseSection() {

  const [programs, setPrograms] = useState([]);
  const navigate = useNavigate();

  // ambil data program
  useEffect(() => {

    fetch(`${import.meta.env.VITE_API_URL}/programs`)
      .then((res) => res.json())
      .then((data) => {
        setPrograms(data);
      })
      .catch((err) => console.error(err));

  }, []);

  return (

    <section className="bg-gradient-to-b from-[#EDE0F5] via-white to-[#DFD0EB]/30 px-10 py-16">

      {/* Header */}
      <div className="max-w-2xl">

        <span className="rounded-full bg-[#DFD0EB] px-4 py-1 text-sm font-medium text-[#6F4D86]">
          Program Terbaru
        </span>

        <h2 className="mt-4 text-4xl font-bold leading-tight text-gray-800">
          Segera Daftar Program Terbaru!
        </h2>

        <p className="mt-3 text-gray-600">
          Pilih program terbaik sesuai minat dan kebutuhanmu
        </p>

      </div>

      {/* Program List */}
      <div className="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3">

        {programs.length > 0 ? (

          programs.map((program) => (

            <div
              key={program.id}
              onClick={() =>
                navigate(`/program/${program.id}`)
              }
              className="group cursor-pointer overflow-hidden rounded-3xl border border-[#E8D9F0] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >

              {/* Image */}
              <div className="relative h-56 w-full overflow-hidden bg-[#EDE0F5]">

                <img
                  src={
                    program.image_url ||
                    "https://dummyimage.com/600x400/e5e7eb/6b7280.jpg&text=Program"
                  }
                  alt={program.nama}
                  className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                />

                {/* Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent" />

              </div>

              {/* Content */}
              <div className="p-6">

                <div className="mb-3 inline-flex rounded-full bg-[#EDE0F5] px-3 py-1 text-xs font-semibold text-[#7A5C92]">
                  VernonEdu Program
                </div>

                <h3 className="text-2xl font-bold text-gray-800 transition group-hover:text-[#7A5C92]">
                  {program.nama}
                </h3>

                <p className="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-500">
                  {program.deskripsi ||
                    "Program pembelajaran interaktif untuk meningkatkan skill dan pengembangan diri."}
                </p>

                {/* Footer */}
                <div className="mt-8 flex items-center justify-between">

                  <span className="inline-flex items-center gap-2 text-sm font-semibold text-[#7A5C92]">

                    Lihat Kelas

                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth={1.8}
                      stroke="currentColor"
                      className="h-4 w-4 transition group-hover:translate-x-1"
                    >

                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M17.25 8.25L21 12l-3.75 3.75M21 12H3"
                      />

                    </svg>

                  </span>

                  <div className="rounded-full bg-[#E8D9F0] p-2 text-[#7A5C92] transition group-hover:bg-[#DFD0EB]">

                    📚

                  </div>

                </div>

              </div>

            </div>

          ))

        ) : (

          <div className="col-span-full rounded-3xl border border-dashed border-[#DFD0EB] bg-white/70 p-14 text-center shadow-sm">

            <p className="text-gray-500">
              Belum ada program tersedia
            </p>

          </div>

        )}

      </div>

      {/* Footer Link */}
      <div className="mt-10 flex justify-end">

        <Link
          to="/program"
          className="inline-flex items-center gap-2 rounded-full bg-[#E8D9F0] px-5 py-3 text-sm font-semibold text-[#6F4D86] transition hover:bg-[#DFD0EB]"
        >

          Lihat Semua →

        </Link>

      </div>

    </section>
  );
}
