export default function MentorCard({mentor}){

  const experiences = [
    "Pengalaman 1",
    "Pengalaman 2",
    "Pengalaman 3"
  ];

  return(

    <div className="bg-white border rounded-xl p-6 shadow hover:shadow-lg transition">

      <img
        src={mentor.image}
        className="w-40 h-40 object-cover mx-auto"
      />

      <h3 className="font-semibold mt-4">
        {mentor.name}
      </h3>

      <p className="text-gray-500 text-sm">
        {mentor.role}
      </p>

      <div className="mt-4 text-left text-sm space-y-1">

        {experiences.map((exp,i)=>(
          <p key={i}>• {exp}</p>
        ))}

      </div>

    </div>

  )

}