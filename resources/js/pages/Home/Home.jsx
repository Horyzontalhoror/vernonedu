import TopBar from "../../components/TopBar";
import AnnouncementBar from "../../components/AnnouncementBar";
import Navbar from "../../components/Navbar";
import Hero from "../../components/Home/Hero";
import SearchBar from "../../components/SearchBar";
import CategoryFilter from "../../components/CategoryFilter";
import CourseCard from "../../components/Program/CourseCard";
import BatchCourseSection from "../../components/BatchCourseSection";
import CategorySection from "../../components/home/CategorySection";
import BenefitsSection from "../../components/home/BenefitsSection";
import PartnerSection from "../../components/home/PartnerSection";
import MentorSection from "../../components/home/MentorSection";
import FAQSection from "../../components/home/FAQSection";
import Footer from "../../components/Footer";

export default function Home() {

  const courses = [
    {
      title:"Public Speaking Mastery",
      mentor:"John Doe"
    },
    {
      title:"Entrepreneurship Basic",
      mentor:"Jane Smith"
    },
    {
      title:"Culinary Business",
      mentor:"Chef Andre"
    }
  ];

  return (
    <div className="bg-gray-50 min-h-screen">
        <TopBar/>
        <AnnouncementBar/>
      <Navbar/>

      <Hero/>

      <section className="px-10 mt-14">

        <BatchCourseSection/>

        <CategorySection/>

        <BenefitsSection/>

        <PartnerSection/>

        <MentorSection/>

        <FAQSection/>

      </section>

      <Footer/>

    </div>
  );
}
