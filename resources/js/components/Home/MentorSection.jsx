import MentorCard from "./MentorCard";

import teacher1 from "./assets/teacher1.png"
import teacher2 from "./assets/teacher2.png"
import teacher3 from "./assets/teacher3.png"
import teacher4 from "./assets/teacher4.png"

export default function MentorSection(){

  const mentors = [
    {
      name:"Kak Olivia",
      role:"Mentor Mindset & Character Building",
      image:teacher2
    },
    {
      name:"Kak Erick",
      role:"Mentor Entrepreneurship",
      image:teacher1
    },
    {
      name:"Kak Ninda",
      role:"Mentor Culinary",
      image:teacher4
    },
    {
      name:"Kak Tanti",
      role:"Mentor Communication",
      image:teacher3
    }
  ];

  return(

    <section className="px-10 py-16 text-center">

      <h2 className="text-3xl font-bold">
        Mentor Kami
      </h2>

      <p className="text-gray-500 mt-2">
        Setiap program dibimbing oleh mentor profesional yang berpengalaman di industri masing-masing
      </p>

      <div className="grid md:grid-cols-4 gap-8 mt-12">

        {mentors.map((mentor,i)=>(
          <MentorCard key={i} mentor={mentor}/>
        ))}

      </div>

    </section>

  )

}