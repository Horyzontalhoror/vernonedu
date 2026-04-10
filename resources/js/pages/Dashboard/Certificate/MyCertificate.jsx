import CertificateCard from "../../../components/dashboard/Certificate/CertificateCard";

export default function MyCertificate(){

  const certificates = [
    {
      title: "Public Speaking",
      score: 93,
      slug: "public-speaking"
    },
    {
      title: "Mindful Parenting",
      score: 96,
      slug: "mindful-parenting"
    }
  ];

  return (

    <div>

      <h1 className="text-2xl font-bold">
        My Certificate
      </h1>

      <div className="mt-6 space-y-4">

        {certificates.map((cert)=>(
          <CertificateCard key={cert.slug} cert={cert}/>
        ))}

      </div>

    </div>

  )

}