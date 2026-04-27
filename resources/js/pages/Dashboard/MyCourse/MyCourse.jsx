import { useEffect, useState } from "react";
import CourseProgressCard from "../../../components/dashboard/MyCourse/CourseProgressCard";

export default function MyCourse() {
  const [courses, setCourses] = useState([]);

  useEffect(() => {
    const fetchCourses = async () => {
      try {
        const token = localStorage.getItem("token");

        const res = await fetch("http://localhost:8000/api/my-courses", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        const data = await res.json();
        setCourses(data);

      } catch (err) {
        console.error(err);
      }
    };

    fetchCourses();
  }, []);

  return (
    <div>
      <div className="flex justify-between items-center">
        <h1 className="text-2xl font-bold">My Course</h1>
        <span className="text-gray-500">History</span>
      </div>

      <div className="bg-white rounded-xl shadow mt-6 p-6">
        {courses.length === 0 ? (
          <p className="text-gray-500">Belum ada course</p>
        ) : (
          courses.map((course, i) => (
            <CourseProgressCard key={i} course={course} />
          ))
        )}
      </div>
    </div>
  );
}
