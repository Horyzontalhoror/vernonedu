import { FaInstagram, FaTiktok, FaPhone, FaMapMarked } from "react-icons/fa";
import logo from "./assets/Logo Transparant.png";

export default function Footer() {
  return (

    <footer className="bg-white mt-20 border-t">

      <div className="px-10 py-12 grid md:grid-cols-3 gap-10 items-start">

        {/* Logo */}

        <img
          src={logo}
          alt="Logo"
          className="h-10 object-contain"
        />


        {/* Lokasi */}

        <div>

          <h3 className="font-semibold mb-3">
            Lokasi
          </h3>
          <FaMapMarked/>
          <p className="text-gray-600 text-sm leading-relaxed">
            Jl. Letjen Sutoyo 102A,
            <br/>
            Bunulrejo, Kecamatan Blimbing,
            <br/>
            Kota Malang, Jawa Timur 65141
          </p>

        </div>


        {/* Contact */}

        <div>

          <h3 className="font-semibold mb-3">
            Hubungi Kami
          </h3>

          <div className="flex gap-4 text-xl">
            <FaPhone/>
          </div>
          <p className="text-gray-600 text-sm">
            (+62) 818-889-400
          </p>


          <h3 className="font-semibold mt-6 mb-2">
            Ikuti Kami
          </h3>

          <div className="flex gap-4 text-xl">
            <FaInstagram/>
            <FaTiktok/>
          </div>

        </div>

      </div>


      {/* bottom */}

      <div className="border-t py-6 text-center text-sm text-gray-600">

        <p className="font-semibold">
          PT. Akademi Indonesia Maju
        </p>

        <p className="mt-1">
          No Izin Pendidikan Informal: 420.3/0021/35.73.406/2022
        </p>

      </div>

    </footer>

  );
}