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

    <section className="relative mx-auto mt-8 flex max-w-screen-xl items-center justify-between overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] px-10 shadow-xl">

      {/* Background Blur */}
      <div className="absolute -left-20 top-10 h-72 w-72 rounded-full bg-white/30 blur-3xl" />
      <div className="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#DFD0EB]/40 blur-3xl" />

      {/* Text Content */}
      <div className="relative z-10 max-w-xl py-20">

        {/* Logo */}
        <img
          src={logo}
          alt="Logo"
          className="h-16 object-contain"
        />

        {/* Badge */}
        <div className="mt-6 inline-flex items-center rounded-full bg-white/70 px-4 py-2 text-sm font-semibold text-[#7A5C92] backdrop-blur">

          🎤 Webinar Public Speaking

        </div>

        {/* Heading */}
        <h1 className="mt-6 text-5xl font-extrabold leading-tight text-gray-800">

          Efek Komunikasi Dalam
          <span className="block text-[#7A5C92]">
            Public Speaking
          </span>

        </h1>

        {/* Description */}
        <p className="mt-6 text-lg leading-relaxed text-gray-600">

          Yuk jadi good speaker dan tentukan efek komunikasi terbaik
          untuk membangun rasa percaya diri sejak sekarang.

        </p>

        {/* CTA */}
        <div className="mt-8 flex items-center gap-4">

          <button
            onClick={handleRegister}
            className="rounded-xl bg-[#7A5C92] px-7 py-4 font-semibold text-white shadow-lg transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
          >

            Daftar Sekarang

          </button>

          <button
            onClick={() => navigate("/jadwal")}
            className="rounded-xl border border-white/50 bg-white/50 px-7 py-4 font-semibold text-[#7A5C92] backdrop-blur transition hover:bg-white/80"
          >

            Lihat Jadwal

          </button>

        </div>

        {/* Mini Info */}
        <div className="mt-10 flex flex-wrap gap-6 text-sm text-gray-600">

          <div>
            <p className="text-2xl font-bold text-[#7A5C92]">
              100+
            </p>
            <p>Peserta Aktif</p>
          </div>

          <div>
            <p className="text-2xl font-bold text-[#7A5C92]">
              20+
            </p>
            <p>Program Belajar</p>
          </div>

          <div>
            <p className="text-2xl font-bold text-[#7A5C92]">
              4.9★
            </p>
            <p>Rating Peserta</p>
          </div>

        </div>

      </div>

      {/* Image */}
      <div className="relative z-10 hidden items-end lg:flex">

        <img
          src={img1}
          alt="hero"
          className="h-[500px] object-contain drop-shadow-2xl"
        />

      </div>

    </section>

  );
}
