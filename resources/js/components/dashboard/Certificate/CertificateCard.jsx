import { Link } from "react-router-dom";
import {
  GraduationCap,
  Download,
  BadgeCheck,
} from "lucide-react";

export default function CertificateCard({ cert }) {

  return (

    <div className="group flex items-center justify-between rounded-3xl border border-[#E8D9F0] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

      {/* LEFT */}
      <div className="flex items-center gap-5">

        {/* ICON */}
        <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] shadow-sm">

          <GraduationCap className="h-8 w-8 text-[#7A5C92]" />

        </div>

        {/* CONTENT */}
        <div>

          {/* STATUS */}
          <div className="mb-2 inline-flex items-center gap-1 rounded-full bg-[#EDE0F5] px-3 py-1 text-xs font-semibold text-[#7A5C92]">

            <BadgeCheck className="h-3.5 w-3.5" />

            Sertifikat Published

          </div>

          {/* TITLE */}
          <Link
            to={`/dashboard/certificate/${cert.slug}`}
            className="block text-xl font-bold text-gray-800 transition hover:text-[#7A5C92]"
          >

            {cert.title}

          </Link>

          {/* DATE */}
          <p className="mt-2 text-sm text-gray-500">

            Diterbitkan pada{" "}

            {cert.issued_at
              ? new Date(cert.issued_at).toLocaleDateString("id-ID", {
                  day: "numeric",
                  month: "long",
                  year: "numeric",
                })
              : "-"}

          </p>

        </div>

      </div>

      {/* RIGHT */}
      <div className="flex items-center gap-3">

        {/* DETAIL */}
        <Link
          to={`/dashboard/certificate/${cert.slug}`}
          className="rounded-xl border border-[#E8D9F0] bg-white px-5 py-3 text-sm font-semibold text-[#7A5C92] transition hover:bg-[#F7F1FB]"
        >

          Detail

        </Link>

        {/* DOWNLOAD */}
        <a
          href={cert.file_url}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-flex items-center gap-2 rounded-xl bg-[#7A5C92] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#68467F]"
        >

          <Download className="h-4 w-4" />

          Unduh

        </a>

      </div>

    </div>

  );

}
