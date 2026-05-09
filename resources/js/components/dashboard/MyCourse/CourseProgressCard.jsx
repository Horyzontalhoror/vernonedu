export default function CourseProgressCard({ course }) {

  return (

    <div className="mb-5 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

      {/* Header */}
      <div className="flex items-start justify-between gap-4">

        <div>

          <h3 className="text-lg font-semibold text-gray-800">
            {course.title}
          </h3>

          <p className="mt-1 text-sm text-gray-500">
            {course.description}
          </p>

        </div>

        <span className="rounded-full bg-orange-100 px-3 py-1 text-sm font-medium text-orange-600">
          {course.progress}%
        </span>

      </div>

      {/* Detail */}
      <div className="mt-4 grid grid-cols-2 gap-4 text-sm">

        <div className="rounded-lg bg-gray-50 p-3">

          <p className="text-gray-500">
            Usia
          </p>

          <p className="font-medium text-gray-800">
            {course.usia}
          </p>

        </div>

        <div className="rounded-lg bg-gray-50 p-3">

          <p className="text-gray-500">
            Harga
          </p>

          <p className="font-medium text-gray-800">
            Rp {Number(course.harga).toLocaleString("id-ID")}
          </p>

        </div>

      </div>

      {/* Progress */}
      <div className="mt-5">

        <div className="mb-2 flex justify-between text-sm">

          <span className="text-gray-600">
            Progress Belajar
          </span>

          <span className="font-medium text-gray-800">
            {course.materi_selesai} / {course.total_materi} materi
          </span>

        </div>

        <div className="h-3 overflow-hidden rounded-full bg-gray-200">

          <div
            className="h-3 rounded-full bg-orange-400 transition-all duration-500"
            style={{
              width: `${course.progress}%`,
            }}
          />

        </div>

      </div>

    </div>

  );
}
