import { useEffect, useState } from "react";

import {
  User,
  Mail,
  Phone,
  Lock,
  MapPin,
  Calendar,
} from "lucide-react";

export default function Profile() {

  const [form, setForm] = useState({

    nama: "",
    email: "",
    no_telepon: "",
    jenis_kelamin: "",
    tanggal_lahir: "",
    alamat: "",

    current_password: "",
    new_password: "",
    confirm_password: "",

  });

  const [loading, setLoading] =
    useState(false);

  /*
  |--------------------------------------------------------------------------
  | FETCH PROFILE
  |--------------------------------------------------------------------------
  */

  useEffect(() => {

    fetchProfile();

  }, []);

  const fetchProfile = async () => {

    try {

      const token =
        localStorage.getItem("token");

      const res = await fetch(

        "http://localhost:8000/api/profile",

        {
          headers: {
            Authorization:
              `Bearer ${token}`,
          },
        }
      );

      const data = await res.json();

      setForm((prev) => ({

        ...prev,

        nama:
          data.nama || "",

        email:
          data.email || "",

        no_telepon:
          data.no_telepon || "",

        jenis_kelamin:
          data.peserta?.jenis_kelamin || "",

        tanggal_lahir:
          data.peserta?.tanggal_lahir || "",

        alamat:
          data.peserta?.alamat || "",

      }));

    } catch (err) {

      console.error(err);

    }

  };

  /*
  |--------------------------------------------------------------------------
  | SAVE
  |--------------------------------------------------------------------------
  */

  const handleSubmit = async (e) => {

    e.preventDefault();

    try {

      setLoading(true);

      const token =
        localStorage.getItem("token");

      await fetch(

        "http://localhost:8000/api/profile",

        {

          method: "PUT",

          headers: {

            "Content-Type":
              "application/json",

            Authorization:
              `Bearer ${token}`,

          },

          body: JSON.stringify(form),

        }
      );

      alert(
        "Profile berhasil diperbarui"
      );

    } catch (err) {

      console.error(err);

    } finally {

      setLoading(false);

    }

  };

  /*
  |--------------------------------------------------------------------------
  | INPUT STYLE
  |--------------------------------------------------------------------------
  */

  const inputClass = `
    w-full rounded-2xl border border-[#E8D9F0]
    bg-white px-4 py-3 text-sm
    outline-none transition
    focus:border-[#C9AEDB]
    focus:ring-4 focus:ring-[#F3EBF8]
  `;

  return (

    <div className="mx-auto max-w-5xl">

      {/* HEADER */}
      <div className="mb-8">

        <h1 className="text-3xl font-bold text-gray-800">

          My Profile

        </h1>

        <p className="mt-2 text-sm text-gray-500">

          Kelola informasi akun dan keamanan profile Anda.

        </p>

      </div>

      <form
        onSubmit={handleSubmit}
        className="space-y-8"
      >

        {/* PROFILE CARD */}
        <div className="overflow-hidden rounded-3xl border border-[#E8D9F0] bg-white shadow-sm">

          {/* TOP */}
          <div className="bg-gradient-to-r from-[#DFD0EB] via-[#E8D9F0] to-[#EDE0F5] px-8 py-8">

            <div className="flex items-center gap-5">

              <div className="flex h-20 w-20 items-center justify-center rounded-3xl bg-white/70 shadow-sm">

                <User className="h-10 w-10 text-[#7A5C92]" />

              </div>

              <div>

                <h2 className="text-2xl font-bold text-gray-800">

                  {form.nama || "User"}

                </h2>

                <p className="mt-1 text-sm text-gray-600">

                  VernonEdu Member

                </p>

              </div>

            </div>

          </div>

          {/* FORM */}
          <div className="grid gap-6 p-8 md:grid-cols-2">

            {/* NAMA */}
            <div>

              <label className="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-700">

                <User className="h-4 w-4 text-[#7A5C92]" />

                Nama

              </label>

              <input
                type="text"
                value={form.nama}
                onChange={(e) =>
                  setForm({
                    ...form,
                    nama: e.target.value,
                  })
                }
                className={inputClass}
              />

            </div>

            {/* EMAIL */}
            <div>

              <label className="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-700">

                <Mail className="h-4 w-4 text-[#7A5C92]" />

                Email

              </label>

              <input
                type="email"
                value={form.email}
                onChange={(e) =>
                  setForm({
                    ...form,
                    email: e.target.value,
                  })
                }
                className={inputClass}
              />

            </div>

            {/* TELEPON */}
            <div>

              <label className="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-700">

                <Phone className="h-4 w-4 text-[#7A5C92]" />

                No Telepon

              </label>

              <input
                type="text"
                value={form.no_telepon}
                onChange={(e) =>
                  setForm({
                    ...form,
                    no_telepon: e.target.value,
                  })
                }
                className={inputClass}
              />

            </div>

            {/* JK */}
            <div>

              <label className="mb-2 text-sm font-semibold text-gray-700">

                Jenis Kelamin

              </label>

              <select
                value={form.jenis_kelamin}
                onChange={(e) =>
                  setForm({
                    ...form,
                    jenis_kelamin:
                      e.target.value,
                  })
                }
                className={inputClass}
              >

                <option value="">
                  Pilih Jenis Kelamin
                </option>

                <option value="L">
                  Laki-laki
                </option>

                <option value="P">
                  Perempuan
                </option>

              </select>

            </div>

            {/* TANGGAL */}
            <div>

              <label className="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-700">

                <Calendar className="h-4 w-4 text-[#7A5C92]" />

                Tanggal Lahir

              </label>

              <input
                type="date"
                value={form.tanggal_lahir}
                onChange={(e) =>
                  setForm({
                    ...form,
                    tanggal_lahir:
                      e.target.value,
                  })
                }
                className={inputClass}
              />

            </div>

            {/* ALAMAT */}
            <div className="md:col-span-2">

              <label className="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-700">

                <MapPin className="h-4 w-4 text-[#7A5C92]" />

                Alamat

              </label>

              <textarea
                rows="3"
                value={form.alamat}
                onChange={(e) =>
                  setForm({
                    ...form,
                    alamat:
                      e.target.value,
                  })
                }
                className={inputClass}
              />

            </div>

          </div>

        </div>

        {/* PASSWORD */}
        <div className="rounded-3xl border border-[#E8D9F0] bg-white p-6 shadow-sm">

        {/* HEADER */}
        <div className="mb-5 flex items-start justify-between gap-4">

            <div>

            <h3 className="flex items-center gap-2 text-lg font-bold text-gray-800">

                <Lock className="h-5 w-5 text-[#7A5C92]" />

                Ganti Password

            </h3>

            <p className="mt-1 text-sm text-gray-500">

                Kosongkan jika tidak ingin mengganti password.

            </p>

            </div>

            <div className="rounded-2xl bg-[#F4ECF9] px-4 py-2 text-xs font-semibold text-[#7A5C92]">

            Security

            </div>

        </div>

        {/* FORM */}
        <div className="grid gap-5 md:grid-cols-3">

            {/* NEW PASSWORD */}
            <div>

            <label className="mb-2 block text-sm font-semibold text-gray-700">

                Password Baru

            </label>

            <input
                type="password"
                value={form.new_password}
                onChange={(e) =>
                setForm({
                    ...form,
                    new_password:
                    e.target.value,
                })
                }
                placeholder="••••••••"
                className={inputClass}
            />

            </div>

            {/* CONFIRM */}
            <div>

            <label className="mb-2 block text-sm font-semibold text-gray-700">

                Konfirmasi Password

            </label>

            <input
                type="password"
                value={form.confirm_password}
                onChange={(e) =>
                setForm({
                    ...form,
                    confirm_password:
                    e.target.value,
                })
                }
                placeholder="••••••••"
                className={inputClass}
            />

            </div>

        </div>

        {/* BUTTON */}
        <div className="mt-6 flex justify-end">

            <button
            disabled={loading}
            className="rounded-2xl bg-[#7A5C92] px-7 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-[#68467F]"
            >

            {loading
                ? "Menyimpan..."
                : "Simpan Perubahan"}

            </button>

        </div>

        </div>

      </form>

    </div>

  );

}
