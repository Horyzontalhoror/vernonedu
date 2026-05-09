import { useNavigate } from "react-router-dom";

import img1 from "./assets/img1.webp";
import logo from "../assets/Logo Transparant.png";

export default function Hero() {

  const navigate = useNavigate();

  const handleRegister = () => {

    // arahkan ke halaman program
    navigate("/program");

  };

  return (

    <section className="mx-auto mt-8 flex max-w-6xl items-center justify-between rounded-xl bg-purple-100 px-10">

      {/* Text Content */}
      <div className="max-w-lg py-16">

        <img
          src={logo}
          alt="Logo"
          className="h-14 object-contain"
        />

        <p className="mt-3 font-semibold text-orange-500">
          Webinar Public Speaking
        </p>

        <h1 className="mt-3 text-4xl font-bold leading-tight text-gray-800">
          Efek Komunikasi Dalam Public Speaking
        </h1>

        <p className="mt-4 text-gray-600">
          Yuk jadi good speaker tentukan efek komunikasinya dari sekarang!
        </p>

        {/* Button */}
        <button
          onClick={handleRegister}
          className="mt-6 rounded-lg bg-orange-400 px-6 py-3 font-medium text-white transition hover:bg-orange-500"
        >
          Daftar Sekarang
        </button>

      </div>

      {/* Image */}
      <div className="flex h-full items-end">

        <img
          src={img1}
          alt="hero"
          className="h-[435px] object-contain"
        />

      </div>

    </section>
  );
}
