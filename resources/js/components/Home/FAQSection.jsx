import FAQItem from "./FAQItem";

export default function FAQSection(){

  const faqs = [
    {
      question:"Apa itu VernonEdu?",
      answer:"VernonEdu merupakan kursus yang menjadi jembatan antara dunia pendidikan dengan industri."
    },
    {
      question:"Bagaimana cara mendaftar kursus di VernonEdu?",
      answer:"Kamu bisa memilih kelas yang tersedia di halaman program kemudian melakukan pendaftaran."
    },
    {
      question:"Dimana lokasi tempat kursus VernonEdu?",
      answer:"Kursus dilaksanakan di VernonEdu Campus."
    },
    {
      question:"Apa perbedaan kursus reguler dan private?",
      answer:"Kursus reguler diikuti beberapa peserta sedangkan private bersifat personal."
    }
  ];

  return(

    <section className="px-10 py-16 bg-purple-100">

      <h2 className="text-3xl font-bold text-center">
        Yang Sering Ditanyakan
      </h2>

      <p className="text-center text-gray-600 mt-2">
        Punya pertanyaan? Kami siap bantu kamu!
      </p>

      <div className="max-w-3xl mx-auto mt-10 space-y-4">

        {faqs.map((faq,i)=>(
          <FAQItem key={i} faq={faq}/>
        ))}

      </div>

    </section>

  )

}