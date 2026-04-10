export default function CalendarGrid(){

  const days = [
    28,29,30,1,2,3,4,
    5,6,7,8,9,10,11,
    12,13,14,15,16,17,18,
    19,20,21,22,23,24,25,
    26,27,28,29,30,31,1
  ];

  return(

    <div className="p-6 border-r w-80">

      <div className="grid grid-cols-7 text-center text-gray-500 mb-4">

        <span>S</span>
        <span>M</span>
        <span>T</span>
        <span>W</span>
        <span>T</span>
        <span>F</span>
        <span>S</span>

      </div>

      <div className="grid grid-cols-7 text-center gap-2">

        {days.map((day,i)=>{

          const active = day === 24

          return(

            <div
              key={i}
              className={`p-2 rounded-full text-sm cursor-pointer
              ${active ? "bg-blue-400 text-white" : "hover:bg-gray-100"}`}
            >

              {day}

            </div>

          )

        })}

      </div>

    </div>

  )
}