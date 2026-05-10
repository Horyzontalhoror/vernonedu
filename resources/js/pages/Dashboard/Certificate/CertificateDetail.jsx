import { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";

export default function CertificateDetail() {

  const { slug } = useParams();

  const [certificate, setCertificate] =
    useState(null);

  const [loading, setLoading] =
    useState(true);

  useEffect(() => {

    const fetchDetail = async () => {

      try {

        const token =
          localStorage.getItem("token");

        const res = await fetch(

          `http://localhost:8000/api/my-certificates/${slug}`,

          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }

        );

        const data = await res.json();

        setCertificate(data);

      } catch (err) {

        console.error(err);

      } finally {

        setLoading(false);

      }

    };

    fetchDetail();

  }, [slug]);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (!certificate) {
    return <div>Certificate tidak ditemukan</div>;
  }

  return (

    <div>

      <Link
        to="/dashboard/certificate"
        className="mb-6 flex items-center gap-2 text-[#7A5C92] hover:underline"
      >
        ← Kembali ke My Certificate
      </Link>

      <h1 className="text-3xl font-bold">
        {certificate.title}
      </h1>

      <p className="mt-2 text-gray-500">
        Sertifikat diterbitkan pada{" "}
        {new Date(
          certificate.issued_at
        ).toLocaleDateString()}
      </p>

      <div className="mt-8 grid gap-8 lg:grid-cols-2">

        {/* Skills */}
        <div className="rounded-3xl border border-[#E8D9F0] bg-white p-6 shadow-sm">

          <h3 className="mb-6 border-b pb-3 text-sm font-semibold text-[#7A5C92]">

            KETERAMPILAN YANG DIPEROLEH

          </h3>

          <div className="flex flex-wrap gap-3">

            {certificate.skills?.map((skill, i) => (

              <span
                key={i}
                className="rounded-full bg-[#EDE0F5] px-4 py-2 text-sm text-[#7A5C92]"
              >
                {skill}
              </span>

            ))}

          </div>

        </div>

        {/* Preview */}
        <div>

          <div className="overflow-hidden rounded-3xl border border-[#E8D9F0] bg-white shadow-sm">

            <img
              src={certificate.file_url}
              alt={certificate.title}
              className="w-full"
            />

          </div>

          <div className="mt-6 flex justify-center">

            <a
              href={certificate.file_url}
              target="_blank"
              rel="noopener noreferrer"
              className="rounded-xl bg-[#7A5C92] px-6 py-3 font-semibold text-white transition hover:bg-[#68467F]"
            >

              ⬇ Unduh Sertifikat

            </a>

          </div>

        </div>

      </div>

    </div>

  );
}
