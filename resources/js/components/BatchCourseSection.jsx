import { useEffect, useState } from "react";
import CourseCard from "./CourseCard";
import { Link } from "react-router-dom";

export default function BatchCourseSection() {

  const [categories, setCategories] = useState([]);
  const [active, setActive] = useState(null);
  const [courses, setCourses] = useState([]);

  // ✅ ambil PROGRAM (category)
  useEffect(() => {
    fetch(`${import.meta.env.VITE_API_URL}/programs`)
      .then(res => res.json())
      .then(data => {
        setCategories(data);

        if (data.length > 0) {
          setActive(data[0].id);
        }
      })
      .catch(err => console.error(err));
  }, []);

  // ✅ ambil SUB PROGRAM (courses)
  useEffect(() => {
    if (active) {
      fetch(`${import.meta.env.VITE_API_URL}/programs/${active}/sub-programs`)
        .then(res => res.json())
        .then(data => setCourses(data))
        .catch(err => console.error(err));
    }
  }, [active]);

  return (

    <section className="px-10 py-16">

      <h2 className="text-3xl font-bold">
        Segera Daftar Kelas Batch Terbaru!
      </h2>

      <p className="text-gray-500 mt-2">
        Berbagai pilihan kelas yang bisa kamu ikuti sekarang juga
      </p>

      {/* ✅ CATEGORY FILTER */}
      <div className="flex gap-4 mt-6 flex-wrap">

        {categories.map((cat) => (

          <button
            key={cat.id}
            onClick={() => setActive(cat.id)}
            className={`px-4 py-2 border rounded-lg transition
              ${active === cat.id
                ? "bg-purple-200 border-purple-400"
                : "bg-white hover:bg-purple-100"}`}
          >
            {cat.nama}
          </button>

        ))}

      </div>

      {/* ✅ COURSE LIST */}
      <div className="grid md:grid-cols-3 gap-6 mt-10">

        {courses.length > 0 ? (
          courses.map((course) => (
            <CourseCard
              key={course.id}
              course={course}
              title={course.name}
              slug={course.slug}
              description={course.description}
              usia={course.usia}
            />
          ))
        ) : (
          <p className="col-span-full text-center text-sm text-gray-500">
            Belum ada sub program tersedia.
          </p>
        )}

      </div>

      <div className="flex justify-end mt-8">
        <Link
          to="/program"
          className="text-purple-600 flex items-center gap-2"
        >
          Lihat Semua →
        </Link>
      </div>

    </section>
  );
}
