import { Search } from "lucide-react";

export default function SearchBar({
  search,
  setSearch,
}) {

  return (

    <div className="mt-10 px-6 lg:px-12">

      <div className="mx-auto max-w-screen-xl">

        <div className="relative">

          {/* Icon */}
          <Search
            className="absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
          />

          {/* Input */}
          <input
            type="text"
            value={search}
            onChange={(e) =>
              setSearch(e.target.value)
            }
            placeholder="Cari sub program seperti Public Speaking..."
            className="w-full rounded-2xl border border-[#E8D9F0] bg-white py-4 pl-14 pr-5 text-sm shadow-sm outline-none transition focus:border-[#C9AEDB] focus:ring-4 focus:ring-[#EDE0F5]"
          />

        </div>

      </div>

    </div>

  );
}
