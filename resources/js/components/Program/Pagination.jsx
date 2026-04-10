export default function Pagination() {
  return (

    <div className="flex justify-center items-center gap-4 mt-10">

      <button className="w-10 h-10 border rounded-full">
        {"<"}
      </button>

      <button className="w-10 h-10 border rounded-full bg-gray-200">
        1
      </button>

      <button className="w-10 h-10 border rounded-full">
        {">"}
      </button>

    </div>

  );
}