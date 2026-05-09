import { useEffect, useState } from "react";

import CourseProgressCard from "../../../components/dashboard/MyCourse/CourseProgressCard";

export default function MyCourse() {

  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {

    const fetchCourses = async () => {

      try {

        const token = localStorage.getItem("token");

        const res = await fetch(
          "http://localhost:8000/api/my-courses",
          {
            headers: {
              Authorization: `Bearer ${token}`,
              Accept: "application/json",
            },
          }
        );

        if (!res.ok) {
          throw new Error(
            "Gagal mengambil data course"
          );
        }

        const data = await res.json();

        setCourses(data);

      } catch (err) {

        console.error(err);

      } finally {

        setLoading(false);

      }
    };

    fetchCourses();

  }, []);

  return (
    <div className="p-6">

      {/* Header */}
      <div className="mb-6 flex items-center justify-between">

        <div>

          <h1 className="text-2xl font-bold text-gray-800">
            My Course
          </h1>

          <p className="mt-1 text-sm text-gray-500">
            Daftar course yang sedang Anda ikuti
          </p>

        </div>

        <div className="rounded-full bg-orange-100 px-4 py-2 text-sm font-medium text-orange-600">
          {courses.length} Course
        </div>

      </div>

      {/* Content */}
      <div className="space-y-5">

        {loading ? (

          <div className="rounded-2xl bg-white p-6 shadow-sm">
            <p className="text-gray-500">
              Loading course...
            </p>
          </div>

        ) : courses.length === 0 ? (

          <div className="rounded-2xl bg-white p-10 text-center shadow-sm">

            <h3 className="text-lg font-semibold text-gray-700">
              Belum Ada Course
            </h3>

            <p className="mt-2 text-sm text-gray-500">
              Anda belum mengambil course apapun
            </p>

          </div>

        ) : (

          courses.map((course) => (
            <CourseProgressCard
              key={course.id}
              course={course}
            />
          ))

        )}

      </div>

    </div>
  );
}
