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

    <section className="px-10 py-16">

      {/* Header */}
      <div className="max-w-2xl">

        <h2 className="text-3xl font-bold text-gray-800">
          Segera Daftar Program Terbaru!
        </h2>

        <p className="mt-2 text-gray-500">
          Pilih program terbaik sesuai minat dan kebutuhanmu
        </p>

      </div>

      {/* Program List */}
      <div className="mt-10 grid gap-6 md:grid-cols-3">

        {programs.length > 0 ? (

          programs.map((program) => (

            <div
              key={program.id}
              onClick={() =>
                navigate(`/program/${program.id}`)
              }
              className="group cursor-pointer overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
            >

              {/* Image */}
              <div className="h-52 w-full overflow-hidden bg-gray-100">

                <img
                  src={
                    program.image_url ||
                    "https://placehold.co/600x400?text=Program"
                  }
                  alt={program.nama}
                  className="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                />

              </div>

              {/* Content */}
              <div className="p-6">

                <h3 className="text-xl font-semibold text-gray-800 group-hover:text-purple-600">
                  {program.nama}
                </h3>

                <p className="mt-3 line-clamp-3 text-sm text-gray-500">
                  {program.deskripsi}
                </p>

                {/* Footer */}
                <div className="mt-6 flex items-center justify-between">

                  <span className="text-sm font-medium text-purple-600">
                    Lihat Kelas
                  </span>

                  <span className="text-lg transition group-hover:translate-x-1">
                    →
                  </span>

                </div>

              </div>

            </div>

          ))

        ) : (

          <div className="col-span-full rounded-2xl bg-gray-50 p-10 text-center">

            <p className="text-gray-500">
              Belum ada program tersedia
            </p>

          </div>

        )}

      </div>

      {/* Footer Link */}
      <div className="mt-8 flex justify-end">

        <Link
          to="/program"
          className="flex items-center gap-2 text-purple-600 transition hover:text-purple-700"
        >
          Lihat Semua →
        </Link>

      </div>

    </section>
  );
}
