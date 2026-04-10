import AnnouncementCard from "../../../components/dashboard/Announcement/AnnouncementCard";

export default function Announcement(){

  const announcements = [
    {
      title:"Pergantian Jadwal Kelas Public Speaking",
      message:"Jadwal kelas untuk 1 November besok diundur dari jam 13:00 ke jam 15:00",
      time:"Today 11:00",
      highlight:true
    },
    {
      title:"Info Webinar Terbaru",
      message:"Daftar dan ikuti webinar communication bertema 'Saya bisa MC'",
      time:"Today 11:00",
      highlight:false
    }
  ];

  return(

    <div>

      <h1 className="text-2xl font-bold">
        Announcement
      </h1>

      <div className="mt-6 space-y-4">

        {announcements.map((ann,i)=>(
          <AnnouncementCard key={i} data={ann}/>
        ))}

      </div>

    </div>

  )
}