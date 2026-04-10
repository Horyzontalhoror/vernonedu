import { useState } from "react";

export default function CourseSection() {

  const categories = [
    "Mindset & Character Building",
    "Entrepreneurship",
    "Culinary",
    "Communication"
  ];

  const [active, setActive] = useState("Communication");

  return (

    <section className="mt-16 px-10">

      <h2 className="text-3xl font-bold">
        Segera Daftar Kelas Batch Terbaru!
      </h2>

      <p className="text-gray-500 mt-2">
        Berbagai pilihan kelas yang bisa kamu ikuti sekarang juga
      </p>

      <div className="flex gap-4 mt-6 flex-wrap">

        {categories.map((cat) => (

          <button
            key={cat}
            onClick={() => setActive(cat)}
            className={`px-4 py-2 border rounded-lg transition
              ${active === cat ? "bg-purple-200 border-purple-300" : "hover:bg-gray-100"}
            `}
          >
            {cat}
          </button>

        ))}

      </div>

    </section>

  );
}
