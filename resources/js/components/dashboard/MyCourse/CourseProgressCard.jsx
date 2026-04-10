export default function CourseProgressCard({course}){

  return(

    <div className="flex items-center gap-4 border rounded-lg p-4 mb-4">

      <div className="w-16 h-16 bg-gray-200 rounded"></div>

      <div className="flex-1">

        <div className="flex justify-between">

          <h3 className="font-semibold">
            {course.title}
          </h3>

          <span>
            {course.progress}%
          </span>

        </div>

        <div className="bg-gray-200 h-2 rounded mt-2">

          <div
            className="bg-orange-400 h-2 rounded"
            style={{width:`${course.progress}%`}}
          />

        </div>

      </div>

    </div>

  )
}