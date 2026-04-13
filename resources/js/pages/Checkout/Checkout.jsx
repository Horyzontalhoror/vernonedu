import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { motion } from "framer-motion";

export default function Checkout() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [program, setProgram] = useState(null);
  const [loading, setLoading] = useState(true);
  const [loadingPay, setLoadingPay] = useState(false);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await fetch(`http://localhost:8000/api/sub-programs/${id}`);
        if (!res.ok) throw new Error("Gagal fetch data");

        const data = await res.json();
        setProgram(data);
      } catch (err) {
        console.error(err);
        setProgram(null);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [id]);

  const handleCheckout = async () => {
    const token = localStorage.getItem("token");

    if (!token) {
      alert("Silakan login terlebih dahulu");
      return;
    }

    setLoadingPay(true);

    try {
      const res = await fetch("http://localhost:8000/api/create-transaction", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
          sub_program_id: program.id,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        alert(data.message || "Gagal membuat transaksi");
        return;
      }

      window.snap.pay(data.snap_token);
    } catch (err) {
      console.error(err);
      alert("Terjadi error");
    } finally {
      setLoadingPay(false);
    }
  };

  if (loading)
    return (
      <div className="min-h-screen flex items-center justify-center text-slate-500">
        Loading...
      </div>
    );

  if (!program)
    return (
      <div className="min-h-screen flex items-center justify-center text-red-500">
        Data tidak ditemukan
      </div>
    );

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center p-6">
      <motion.div
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        className="w-full max-w-4xl bg-white rounded-3xl shadow-xl grid md:grid-cols-2 overflow-hidden"
      >
        {/* LEFT */}
        <div className="p-8 flex flex-col justify-between">
          <div>
            <h1 className="text-2xl font-bold text-slate-900">
              Checkout Program
            </h1>
            <p className="text-sm text-slate-500 mt-1">
              Periksa detail sebelum melanjutkan pembayaran
            </p>

            <div className="mt-6 space-y-4">
              <div className="p-4 rounded-xl border bg-slate-50">
                <h2 className="font-semibold text-slate-800">
                  {program.name}
                </h2>
                <p className="text-sm text-slate-600 mt-1">
                  {program.description}
                </p>
              </div>

              <div className="flex justify-between items-center border-t pt-4">
                <span className="text-sm text-slate-500">
                  Total Pembayaran
                </span>
                <span className="text-xl font-bold text-slate-900">
                  Rp {program.harga || "-"}
                </span>
              </div>
            </div>
          </div>

          <button
            onClick={() => navigate(-1)}
            className="text-sm text-slate-400 mt-6 hover:text-slate-600"
          >
            ← Kembali
          </button>
        </div>

        {/* RIGHT */}
        <div className="bg-gradient-to-br from-purple-600 to-blue-500 p-8 text-white flex flex-col justify-between">
          <div>
            <h2 className="text-lg font-semibold">Pembayaran Aman</h2>
            <p className="text-sm opacity-80 mt-2">
              Transaksi Anda dilindungi oleh sistem pembayaran Midtrans
            </p>
          </div>

          <div className="space-y-4">
            <button
              onClick={handleCheckout}
              disabled={loadingPay}
              className="w-full bg-white text-purple-600 py-3 rounded-xl font-semibold hover:opacity-90 transition disabled:opacity-50"
            >
              {loadingPay ? "Memproses..." : "Bayar Sekarang"}
            </button>

            <p className="text-xs text-center opacity-70">
              Dengan melanjutkan, Anda menyetujui syarat & ketentuan
            </p>
          </div>
        </div>
      </motion.div>
    </div>
  );
}
