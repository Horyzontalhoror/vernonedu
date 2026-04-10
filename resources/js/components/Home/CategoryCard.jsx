export default function CategoryCard({ cat }){

  return(

    <div className="bg-gray-100 border border-purple-200 rounded-3xl p-8 text-center shadow-sm hover:shadow-xl transition w-56">

      <div className="flex justify-center mb-6">

        <img
          src={cat.icon}
          alt={cat.name}
          className="w-16 h-16 object-contain"
        />

      </div>

      <h3 className="font-semibold text-gray-700 leading-snug">
        {cat.name}
      </h3>

      <div className="flex justify-center mt-6">

        <button className="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow hover:scale-110 transition">
          →
        </button>

      </div>

    </div>

  )

}
