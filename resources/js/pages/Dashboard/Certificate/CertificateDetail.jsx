import { useParams, Link } from "react-router-dom";

export default function CertificateDetail(){

  const { slug } = useParams();

  const skills = [
    "Keterampilan 1",
    "Keterampilan 2",
    "Keterampilan 3",
    "Keterampilan 4",
    "Keterampilan 5",
    "Keterampilan 6"
  ];

  return(

    <div>

      <Link
        to="/dashboard/certificate"
        className="text-blue-500 hover:underline flex items-center gap-2 mb-6"
      >
        ← Kembali ke My Certificate
      </Link>

      <h1 className="text-2xl font-bold">
        My Certificate
      </h1>

      <h2 className="mt-6 font-semibold capitalize">
        {slug}
      </h2>

      <div className="grid grid-cols-2 gap-8 mt-6">

        {/* skills */}
        <div className="border rounded-lg p-6">

          <h3 className="text-sm text-gray-500 mb-4 border-b pb-3">
            KETERAMPILAN YANG AKAN DI PEROLEH
          </h3>

          <div className="flex flex-wrap gap-3">

            {skills.map((skill,i)=>(
              <span
                key={i}
                className="px-3 py-1 border rounded-full text-sm"
              >
                {skill}
              </span>
            ))}

          </div>

        </div>

        {/* certificate preview */}

        <div>

          <div className="border rounded-lg h-60 bg-gray-200"></div>

          <div className="mt-6 flex justify-center">

            <button className="border px-6 py-2 rounded-lg flex items-center gap-2">
              ⬇ Unduh Sertifikat
            </button>

          </div>

        </div>

      </div>

    </div>

  )

}