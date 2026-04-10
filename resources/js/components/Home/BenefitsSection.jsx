import img1 from "./assets/h1.png"

export default function BenefitsSection(){

  const benefits = [
    "Certificate of Participation and Competency",
    "Jaringan Komunitas Alumni",
    "Ruang Belajar & Kitchen Studio yang Nyaman",
    "Gabung Career Acceleration Program",
    "Biaya Terjangkau",
    "Waktu Belajar Cepat"
  ];

  return(

    <section className="px-10 py-16">

      <div className="grid md:grid-cols-2 gap-12 items-center">

        {/* image */}

        <img
          src={img1}
          className="rounded-xl shadow"
        />

        {/* text */}

        <div>

          <h2 className="text-3xl font-bold">
            Belajar Bersama VernonEdu
          </h2>

          <p className="text-gray-600 mt-2">
            Kamu Bakal Dapet Apa Aja?
          </p>

          <div className="mt-8 space-y-4">

            {benefits.map((item,i)=>(

              <div key={i} className="flex items-center gap-4">

                <div className="w-10 h-10 border rounded-full flex items-center justify-center text-blue-500">
                  ✓
                </div>

                <p className="text-gray-700">
                  {item}
                </p>

              </div>

            ))}

          </div>

        </div>

      </div>

    </section>

  )

}