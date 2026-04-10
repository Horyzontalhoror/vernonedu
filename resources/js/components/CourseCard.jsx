export default function CourseCard({ course }) {

  if (!course) return null;

  return (

    <div className="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

      <img
        src="https://via.placeholder.com/400x200"
        alt={course.name}
        className="w-full h-40 object-cover"
      />

      <div className="p-4">

        <h3 className="font-semibold text-slate-900">
          {course.name}
        </h3>

        {/* Ganti category → usia */}
        <p className="text-gray-500 text-sm mt-1">
          {course.usia ? `Usia ${course.usia}` : 'Program tersedia'}
        </p>

        {/* <div className="flex justify-end mt-4">

          <button className="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 text-white flex items-center justify-center">
            →
          </button>

        </div> */}

      </div>

    </div>

  );
}
