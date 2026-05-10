import {
  FaInstagram,
  FaTiktok,
  FaPhone,
  FaMapMarkedAlt,
} from "react-icons/fa";

import logo from "./assets/Logo Transparant.png";

export default function Footer() {

  return (

    <footer className="mt-24 border-t border-[#E8D9F0] bg-gradient-to-b from-white via-[#FDFBFE] to-[#F6F0FA]">

      {/* MAIN */}
      <div className="mx-auto grid max-w-screen-xl gap-12 px-6 py-16 md:grid-cols-3 lg:px-12">

        {/* LOGO */}
        <div>

          <img
            src={logo}
            alt="Logo"
            className="h-14 object-contain"
          />

          <p className="mt-5 text-sm leading-relaxed text-gray-600">

            VernonEdu hadir untuk membantu peserta mengembangkan
            kemampuan komunikasi, mindset, karakter, dan skill masa depan
            melalui pembelajaran interaktif dan modern.

          </p>

          {/* SOCIAL */}
          <div className="mt-6 flex gap-4">

            <a
              href="#"
              className="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#EDE0F5] text-[#7A5C92] transition hover:scale-105 hover:bg-[#DFD0EB]"
            >

              <FaInstagram size={18} />

            </a>

            <a
              href="#"
              className="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#EDE0F5] text-[#7A5C92] transition hover:scale-105 hover:bg-[#DFD0EB]"
            >

              <FaTiktok size={18} />

            </a>

          </div>

        </div>

        {/* LOKASI */}
        <div>

          <div className="mb-5 flex items-center gap-3">

            <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5]">

              <FaMapMarkedAlt className="text-[#7A5C92]" />

            </div>

            <h3 className="text-lg font-bold text-gray-800">

              Lokasi

            </h3>

          </div>

          <p className="text-sm leading-relaxed text-gray-600">

            Jl. Letjen Sutoyo 102A,
            <br />
            Bunulrejo, Kecamatan Blimbing,
            <br />
            Kota Malang, Jawa Timur 65141

          </p>

        </div>

        {/* CONTACT */}
        <div>

          <div className="mb-5 flex items-center gap-3">

            <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5]">

              <FaPhone className="text-[#7A5C92]" />

            </div>

            <h3 className="text-lg font-bold text-gray-800">

              Hubungi Kami

            </h3>

          </div>

          <p className="text-sm text-gray-600">

            (+62) 818-889-400

          </p>

          {/* EXTRA */}
          <div className="mt-8 rounded-3xl border border-[#E8D9F0] bg-white/70 p-5 shadow-sm backdrop-blur">

            <p className="text-sm font-semibold text-[#7A5C92]">

              🎓 VernonEdu Learning Center

            </p>

            <p className="mt-2 text-xs leading-relaxed text-gray-500">

              Platform pembelajaran untuk membantu generasi muda
              meningkatkan skill komunikasi dan pengembangan diri.

            </p>

          </div>

        </div>

      </div>

      {/* BOTTOM */}
      <div className="border-t border-[#E8D9F0] bg-white/70 py-6">

        <div className="mx-auto flex max-w-screen-xl flex-col items-center justify-between gap-4 px-6 text-center text-sm text-gray-600 md:flex-row lg:px-12">

          <div>

            <p className="font-semibold text-gray-800">

              PT. Akademi Indonesia Maju

            </p>

            <p className="mt-1 text-xs text-gray-500">

              No Izin Pendidikan Informal:
              420.3/0021/35.73.406/2022

            </p>

          </div>

          <p className="text-xs text-gray-400">

            © {new Date().getFullYear()} VernonEdu.
            All rights reserved.

          </p>

        </div>

      </div>

    </footer>

  );

}
