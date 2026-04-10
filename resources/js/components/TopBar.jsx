import ig from "./assets/instagram-icon.png"
import wa from "./assets/wa-icon.png"
import ttk from './assets/tiktok-icon.png'

export default function TopBar() {
  return (
    <div className="bg-gray-100 text-sm py-2 px-10 flex gap-6 items-center">

      <div className="flex items-center gap-2">
        <img src={wa} className="w-5" />
        <span className="text-green-600">+62 818-889-400</span>
      </div>
      <div className="flex items-center gap-2">
        <img src={ig} className="w-5" />
        <span className="text-pink-500">@vernonedu</span>
      </div>
      <div className="flex items-center gap-2">
        <img src={ttk} className="w-5" />
        <span>vernonedu</span>
      </div>

    </div>
  );
}