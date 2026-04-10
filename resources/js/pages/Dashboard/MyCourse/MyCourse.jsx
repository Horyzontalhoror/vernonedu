import CourseProgressCard from "../../../components/dashboard/MyCourse/CourseProgressCard";

export default function MyCourse(){

  const courses = [
    {
      title:"Entrepreneurship",
      progress:50
    },
    {
      title:"Public Speaking",
      progress:25
    }
  ];

  return(

    <div>

      <div className="flex justify-between items-center">

        <h1 className="text-2xl font-bold">
          My Course
        </h1>

        <span className="text-gray-500">
          History
        </span>

      </div>

      <div className="bg-white rounded-xl shadow mt-6 p-6">

        {courses.map((course,i)=>(
          <CourseProgressCard key={i} course={course}/>
        ))}

      </div>

    </div>

  )
}