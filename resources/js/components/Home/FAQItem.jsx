import { useState } from "react";

export default function FAQItem({faq}){

  const [open,setOpen] = useState(false);

  return(

    <div className="bg-white border border-gray-200 rounded-xl shadow-sm">

      <button
        onClick={()=>setOpen(!open)}
        className="w-full flex items-center justify-between p-4 text-left font-medium text-gray-800 hover:bg-gray-50 transition"
      >

        <span>{faq.question}</span>

        <span className="text-xl w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-blue-500 text-white shadow hover:scale-110 transition">
          {open ? "−" : "+"}
        </span>

      </button>

      {open && (

        <div className="px-4 pb-4 text-gray-600 border-t border-gray-100">
          {faq.answer}
        </div>

      )}

    </div>

  )

}