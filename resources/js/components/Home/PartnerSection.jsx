import aletheia from "./assets/aletheia.png"
import charis from "./assets/charis.png"
import smaksanto from "./assets/smaksanto.png"
import smeka from "./assets/smeka.png"
import smkn2 from "./assets/smkn2.png"
import smkn12 from "./assets/smkn12.png"

export default function PartnerSection() {
  const partners = [
    { src: aletheia, name: "Aletheia" },
    { src: charis, name: "Charis" },
    { src: smaksanto, name: "SMAK Santo" },
    { src: smeka, name: "SMEKA" },
    { src: smkn2, name: "SMKN 2" },
    { src: smkn12, name: "SMKN 12" },
  ];

  const marqueePartners = [...partners, ...partners, ...partners];
  const animationStyles = {
    animationDuration: `${partners.length * 4}s`,
    animationTimingFunction: 'linear',
    animationIterationCount: 'infinite',
  };

  return (
    <section className="py-16 bg-gradient-to-r from-purple-600 to-blue-600 text-center">
      <h2 className="text-3xl font-bold text-white">Partner Kami</h2>

      <p className="text-white/80 mt-2">
        VernonEdu telah membangun kolaborasi yang kuat dengan institusi pendidikan di seluruh Indonesia
      </p>

      <div className="relative mt-10 overflow-hidden group">
        <span
          aria-hidden="true"
          className="pointer-events-none absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-purple-700 via-purple-600/60 to-transparent"
        />
        <span
          aria-hidden="true"
          className="pointer-events-none absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-blue-700 via-blue-600/60 to-transparent"
        />

        <div
          className="flex w-max gap-10 animate-scroll group-hover:[animation-play-state:paused]"
          style={animationStyles}
          role="list"
          aria-label="Daftar institusi mitra VernonEdu"
        >
          {marqueePartners.map((partner, index) => (
            <div
              key={`${partner.name}-${index}`}
              role="listitem"
              className="bg-white/95 w-40 h-40 rounded-full flex items-center justify-center shadow-xl shadow-purple-900/10 shrink-0 transition duration-500 ease-out hover:-translate-y-2 hover:scale-105 hover:shadow-purple-500/30"
            >
              <img
                src={partner.src}
                alt={`Logo ${partner.name}`}
                className="w-28 object-contain opacity-90"
                loading="lazy"
              />
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
