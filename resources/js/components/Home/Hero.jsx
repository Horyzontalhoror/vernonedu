import img1 from "./assets/img1.webp";
import logo from "../assets/Logo Transparant.png";

export default function Hero() {
  return (
    <section className="max-w-6xl mx-auto mt-8 bg-purple-100 rounded-xl px-10 flex items-center justify-between">

    {/* Text Content */}
    <div className="max-w-lg py-16">

        <img
        src={logo}
        alt="Logo"
        className="h-14 object-contain"
        />

        <p className="text-orange-500 font-semibold mt-3">
        Webinar Public Speaking
        </p>

        <h1 className="text-4xl font-bold mt-3 leading-tight">
        Efek Komunikasi Dalam Public Speaking
        </h1>

        <p className="mt-4 text-gray-600">
        Yuk jadi good speaker tentukan efek komunikasinya dari sekarang!
        </p>

        <button className="mt-6 bg-orange-400 text-white px-6 py-3 rounded-lg">
        Register Now
        </button>

    </div>

    {/* Image */}
    <div className="flex items-end h-full">

        <img
        src={img1}
        alt="hero"
        className="h-[435px] object-contain"
        />

    </div>

    </section>
  );
}