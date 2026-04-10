import CategoryCard from "./CategoryCard";

import img1 from "./assets/comm.png"
import img2 from "./assets/culinary.png"
import img3 from "./assets/Entre.png"
import img4 from "./assets/mcb.png"

export default function CategorySection(){

  const categories = [
    {
      name:"Mindset & Character Building",
      icon:img4
    },
    {
      name:"Entrepreneurship",
      icon:img3
    },
    {
      name:"Culinary",
      icon: img2
    },
    {
      name:"Communication",
      icon: img1
    }
  ];

  return(

    <section className="px-10 py-20 bg-gradient-to-r from-purple-100 to-blue-100">

      <h2 className="text-4xl font-bold text-center">
        Temukan Kelas Berdasarkan Kategori
      </h2>

      <p className="text-gray-600 text-center mt-3">
        Terdapat pilihan kelas reguler dan private sesuai kebutuhanmu
      </p>

      <div className="grid grid-cols-4 gap-10 justify-items-center mt-14">

        {categories.map((cat,i)=>(
          <CategoryCard key={i} cat={cat}/>
        ))}

      </div>

    </section>

  )

}
