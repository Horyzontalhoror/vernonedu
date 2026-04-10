import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import TopBar from "../../components/TopBar";
import AnnouncementBar from "../../components/AnnouncementBar";
import Navbar from "../../components/Navbar";
import CategoryFilter from "../../components/CategoryFilter";
import CourseCard from "../../components/Program/CourseCard";
import Pagination from "../../components/Program/Pagination";
import SearchBar from "../../components/SearchBar";
import Footer from "../../components/Footer";
import ProgramDetail from "./ProgramDetail";

const API_URL = import.meta.env.VITE_API_URL;

export default function Program() {
  const { slug } = useParams();
  const navigate = useNavigate();
  const [active, setActive] = useState(null);
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [detail, setDetail] = useState(null);
  const [detailLoading, setDetailLoading] = useState(false);
  const [detailError, setDetailError] = useState(null);

  useEffect(() => {
    if (!active) {
      return;
    }

    setLoading(true);
    setError(null);

    fetch(`${API_URL}/programs/${active}/sub-programs`)
      .then((res) => {
        if (!res.ok) {
          throw new Error('Gagal memuat sub program');
        }
        return res.json();
      })
      .then((data) => {
        setCourses(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error('Error fetch sub programs:', err);
        setError('Tidak dapat memuat data kelas. Coba lagi.');
        setLoading(false);
      });
  }, [active]);

  useEffect(() => {
    if (!slug) {
      setDetail(null);
      setDetailError(null);
      setDetailLoading(false);
      return;
    }

    setDetailLoading(true);
    setDetailError(null);

    fetch(`${API_URL}/sub-programs/${slug}`)
      .then((res) => {
        if (!res.ok) {
          throw new Error('Gagal memuat detail program');
        }
        return res.json();
      })
      .then((payload) => {
        setDetail(payload);
        setDetailLoading(false);
        setActive((previous) =>
          previous === payload.program_id ? previous : payload.program_id
        );
      })
      .catch((err) => {
        console.error('Error fetch sub program:', err);
        setDetailError('Data tidak ditemukan.');
        setDetailLoading(false);
      });
  }, [slug]);

  const handleProgramChange = (programId) => {
    setActive(programId);
    if (slug) {
      navigate('/program');
    }
  };

  const handleCourseSelect = (courseSlug) => {
    if (!courseSlug || slug === courseSlug) {
      return;
    }

    navigate(`/program/${courseSlug}`);
  };

  const handleClearDetail = () => {
    if (!slug) {
      return;
    }

    navigate('/program');
  };

  return (
    <div className="bg-gray-50 min-h-screen">
      <TopBar />
      <AnnouncementBar />
      <Navbar />

      <SearchBar />

      <section className="text-center mt-14">
        <h1 className="text-4xl font-bold">Cari Kelas Berdasarkan Program!</h1>

        <CategoryFilter active={active} setActive={handleProgramChange} />
      </section>

      <section className="px-6 lg:px-12 mt-14">
        <div className="grid gap-10 lg:grid-cols-[1.4fr,1fr]">
          <div>
            {loading && (
              <div className="text-center text-gray-500">Memuat daftar kelas...</div>
            )}

            {error && !loading && (
              <div className="text-center text-red-500">{error}</div>
            )}

            {!loading && !error && courses.length === 0 && active && (
              <div className="text-center text-gray-500">Belum ada sub program untuk program ini.</div>
            )}

            {!loading && !error && courses.length > 0 && (
              <div className="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                {courses.map((course) => (
                  <CourseCard
                    key={course.slug}
                    title={course.name}
                    slug={course.slug}
                    description={course.description}
                    usia={course.usia}
                    isActive={slug === course.slug}
                    onSelect={handleCourseSelect}
                  />
                ))}
              </div>
            )}

            <Pagination />
          </div>

          <ProgramDetail
            data={detail}
            loading={detailLoading}
            error={detailError}
            onClear={handleClearDetail}
          />
        </div>
      </section>

      <Footer />
    </div>
  );
}
