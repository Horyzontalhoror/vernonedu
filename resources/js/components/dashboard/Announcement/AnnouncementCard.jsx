export default function AnnouncementCard({data}){

  return(

    <div
      className={`border rounded-lg p-6 flex justify-between items-start
      ${data.highlight ? "bg-purple-100 border-purple-300" : "bg-white"}`}
    >

      <div>

        <h3 className="font-semibold">

          {data.title}

        </h3>

        <p className="text-gray-600 mt-2 text-sm">

          {data.message}

        </p>

      </div>

      <span className="text-gray-400 text-sm">

        {data.time}

      </span>

    </div>

  )

}