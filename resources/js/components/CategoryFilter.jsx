import { useEffect, useState } from "react";

export default function CategoryFilter({ active, setActive }) {

  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`${import.meta.env.VITE_API_URL}/programs`)
      .then(res => res.json())
      .then(data => {
        setCategories(data);
        setLoading(false);
      })
      .catch(err => {
        console.error("Error fetch categories:", err);
        setLoading(false);
      });
  }, []);

  useEffect(() => {
    if (!loading && categories.length && !active) {
      setActive(categories[0].id);
    }
  }, [loading, categories, active, setActive]);

  if (loading) {
    return <div className="text-center mt-6">Loading categories...</div>;
  }

  return (
    <div className="flex justify-center gap-4 mt-6 flex-wrap">

      {categories.map((cat) => (

        <button
          key={cat.id}
          onClick={() => setActive(cat.id)}
          className={`px-4 py-2 rounded-lg border transition
          ${active === cat.id
            ? "bg-purple-200 border-purple-400"
            : "bg-white hover:bg-gray-100"}`}
        >
          {cat.nama}
        </button>

      ))}

    </div>
  );
}
