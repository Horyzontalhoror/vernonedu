import { Search } from "lucide-react";

export default function SearchBar({
  search,
  setSearch,
}) {

  return (

    <div className="mt-10 px-6 lg:px-12">

      <div className="mx-auto max-w-screen-xl">

        {/* Container */}
        <div className="relative overflow-hidden rounded-3xl border border-[#E8D9F0] bg-gradient-to-r from-[#DFD0EB]/40 via-[#E8D9F0]/30 to-[#EDE0F5]/40 p-2 shadow-sm backdrop-blur">

          {/* Glow */}
          <div className="absolute -left-10 top-0 h-24 w-24 rounded-full bg-white/30 blur-2xl" />
          <div className="absolute bottom-0 right-0 h-24 w-24 rounded-full bg-[#DFD0EB]/40 blur-2xl" />

          {/* Input Wrapper */}
          <div className="relative flex items-center rounded-2xl bg-white/80 backdrop-blur">

            {/* Icon */}
            <div className="pointer-events-none absolute left-5 flex items-center justify-center">

              <Search className="h-5 w-5 text-[#7A5C92]" />

            </div>

            {/* Input */}
            <input
              type="text"
              value={search}
              onChange={(e) =>
                setSearch(e.target.value)
              }
              placeholder="Cari sub program seperti Public Speaking..."
              className="w-full bg-transparent py-4 pl-14 pr-5 text-sm text-gray-700 outline-none placeholder:text-gray-400"
            />

          </div>

        </div>

      </div>

    </div>

  );
}
