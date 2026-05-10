import { useEffect, useState } from "react";

import CertificateCard from "../../../components/dashboard/Certificate/CertificateCard";

export default function MyCertificate() {

  const [certificates, setCertificates] = useState([]);

  useEffect(() => {

    const fetchCertificates = async () => {

      try {

        const token =
          localStorage.getItem("token");

        const res = await fetch(
          "http://localhost:8000/api/my-certificates",
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        const data = await res.json();

        setCertificates(data);

      } catch (err) {

        console.error(err);

      }

    };

    fetchCertificates();

  }, []);

  return (

    <div>

      <h1 className="text-2xl font-bold">
        My Certificate
      </h1>

      <div className="mt-6 space-y-4">

        {certificates.length > 0 ? (

          certificates.map((cert) => (

            <CertificateCard
              key={cert.id}
              cert={cert}
            />

          ))

        ) : (

          <div className="rounded-2xl border border-dashed p-10 text-center text-gray-500">

            Belum ada sertifikat

          </div>

        )}

      </div>

    </div>

  );
}
