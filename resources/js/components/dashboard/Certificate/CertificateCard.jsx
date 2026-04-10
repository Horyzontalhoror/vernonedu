import { Link } from "react-router-dom";

export default function CertificateCard({ cert }) {

  return (

    <div className="bg-white border rounded-lg p-6 flex items-center justify-between shadow-sm">

      <div className="flex items-center gap-4">

        {/* icon */}
        <div className="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
          📜
        </div>

        <div>

          <Link
            to={`/dashboard/certificate/${cert.slug}`}
            className="font-semibold text-lg hover:text-blue-500"
          >
            {cert.title}
          </Link>

          <p className="text-gray-500 text-sm mt-1">
            Nilai yang di capai: {cert.score}
          </p>

        </div>

      </div>

      <button className="bg-blue-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-500">
        Unduh
      </button>

    </div>

  )

}