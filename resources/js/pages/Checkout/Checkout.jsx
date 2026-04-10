import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";

export default function Checkout() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [program, setProgram] = useState(null);
  const [loading, setLoading] = useState(true);

  // 🔥 ambil data program
  useEffect(() => {
    fetch(`http://localhost:8000/api/sub-programs/${id}`)
      .then(res => res.json())
      .then(data => setProgram(data))
      .finally(() => setLoading(false));
  }, [id]);

  const handleCheckout = async () => {
    const token = localStorage.getItem("token");

    try {
      const res = await fetch("http://localhost:8000/api/create-transaction", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
          sub_program_id: id,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        alert(data.message || "Gagal membuat transaksi");
        return;
      }

      // 🔥 next step (sandbox payment)
      alert("Transaksi dibuat, lanjut ke pembayaran");

      console.log(data);

    } catch (err) {
      console.error(err);
      alert("Terjadi error");
    }
  };

  if (loading) return <div className="p-10">Loading...</div>;

  if (!program) return <div className="p-10">Data tidak ditemukan</div>;

  return (
    <div className="max-w-3xl mx-auto p-6">

      <div className="bg-white rounded-3xl shadow-lg p-6 space-y-6">

        {/* HEADER */}
        <div>
          <h1 className="text-xl font-bold text-slate-900">
            Checkout Program
          </h1>
          <p className="text-sm text-slate-500">
            Pastikan data Anda sudah benar sebelum melanjutkan
          </p>
        </div>

        {/* PROGRAM INFO */}
        <div className="border rounded-xl p-4">
          <h2 className="font-semibold text-slate-800">
            {program.name}
          </h2>

          <p className="text-sm text-slate-600 mt-1">
            {program.description}
          </p>
        </div>

        {/* PRICE */}
        <div className="flex justify-between items-center border-t pt-4">
          <span className="text-sm text-slate-500">
            Total Pembayaran
          </span>

          <span className="text-lg font-bold text-slate-900">
            Rp {program.harga || "Hubungi Admin"}
          </span>
        </div>

        {/* ACTION */}
        <button
          onClick={handleCheckout}
          className="w-full bg-gradient-to-r from-purple-600 to-blue-500 text-white py-3 rounded-xl font-semibold"
        >
          Bayar Sekarang
        </button>

        <button
          onClick={() => navigate(-1)}
          className="w-full text-sm text-slate-500"
        >
          Kembali
        </button>

      </div>

    </div>
  );
}
