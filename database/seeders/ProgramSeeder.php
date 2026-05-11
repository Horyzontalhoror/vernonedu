<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // PROGRAM #1 - KURSUS Mindset & Character Building
        // =====================================================

        $programId = DB::table('programs')->insertGetId([
            'nama' => 'KURSUS Mindset & Character Building',
            'deskripsi' => 'Kami percaya bahwa “kunci sukses terletak pada petaninya, bukan ladangnya.” Karena itu, kami meyakini bahwa kemampuan dan karakter individu adalah fondasi utama masa depan seseorang. Program ini dirancang untuk membentuk kebiasaan positif, pola pikir tangguh, dan karakter yang dilandasi nilai-nilai seperti integritas, tanggung jawab, empati, dan semangat belajar—agar mereka siap menghadapi tantangan dan memberi dampak positif bagi sekitarnya.',
            'image_url' => 'https://thumbs.dreamstime.com/b/growth-mindset-versus-fixed-concept-wooden-blocks-positioned-human-head-silhouette-representing-psychological-413574827.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Habit Building',
                'slug' => Str::slug('Habit Building'),
                'description' => 'Kursus ini bertujuan membangun kebiasaan-kebiasaan yang positif untuk seorang anak sehingga menumbuhkan hal-hal yang menjadi fondasi untuk melatih mindset & karakter ke depannya. Misalkan kebiasaan literasi sebagai fondasi pembentukan growth mindset.',
                'usia' => '6-9 tahun',
                'harga' => 1,
                'image_url' => 'https://img.freepik.com/free-photo/old-new-habits-concept_23-2148537773.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Mindset & Character Building',
                'slug' => Str::slug('Mindset & Character Building'),
                'description' => 'Kursus ini bertujuan membangun mindset & character melalui activity-based-learning & project-based-learning. Di setiap pertemuan akan melatih mindset & character seperti growth mindset, agility mindset, dll hingga tertanam dalam kebiasaan dan menjadi bagian dalam kehidupan sehari-hari.',
                'usia' => '10-22 tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/side-view-smiley-man-with-bicycle_23-2150043703.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =====================================================
        // PROGRAM #2 - KURSUS ENTREPRENEURSHIP
        // =====================================================

        $programId = DB::table('programs')->insertGetId([
            'nama' => 'KURSUS ENTREPRENEURSHIP',
            'deskripsi' => 'Kami percaya bahwa “kunci sukses terletak pada entrepreneurnya”, karena bisnis akan terus berubah, pasar akan terus bergerak—namun fondasi seorang entrepreneur yang kuatlah yang menentukan keberlanjutan dan kesuksesan usaha. Program ini dirancang untuk membangun mindset kewirausahaan yang adaptif, tangguh, dan berdampak. Kami membekali peserta dengan fondasi berpikir bisnis yang kuat agar mampu membangun konsep, strategi, dan eksekusi yang relevan.',
            'image_url' => 'https://thumbs.dreamstime.com/b/lead-186965120.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Business Creation Series',
                'slug' => Str::slug('Business Creation Series'),
                'description' => 'Program ini akan melatih mindset seorang entrepreneur, mengajarkan membuat ide bisnis yang sustainable & scalable, memvalidasi bisnis, melatih softskill & hardskill yang dibutuhkan dalam bisnis dan mengeksekusi bisnis, termasuk evaluasi dan analisa bisnisnya.',
                'usia' => '15-60 tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/premium-photo/business-people-meeting-office-with-graph-chart-board-collaboration-discussion-financial-report_44344-7060.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Business Administration',
                'slug' => Str::slug('Business Administration'),
                'description' => 'Program ini akan mengajarkan skill administrasi yang perlu dikuasai oleh entrepreneur sehingga dapat mengatur administrasi dalam bisnisnya secara benar.',
                'usia' => '15-60 tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/young-ethnic-coworkers-using-tablet_1098-22100.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =====================================================
        // PROGRAM #3 - KURSUS PROFESSIONAL
        // =====================================================

        $programId = DB::table('programs')->insertGetId([
            'nama' => 'KURSUS KOMUNIKASI',
            'deskripsi' => 'Kami percaya bahwa “kunci sukses terletak pada keterampilan dan profesionalisme yang dimiliki”, karena dunia kerja akan terus berubah, teknologi akan terus berkembang—namun keterampilan dan profesionalisme yang kuatlah yang menentukan keberlanjutan dan kesuksesan karier. Program ini dirancang untuk membangun keterampilan dan profesionalisme yang adaptif, tangguh, dan berdampak. Kami membekali peserta dengan keterampilan dan profesionalisme yang kuat agar mampu membangun konsep, strategi, dan eksekusi yang relevan.',
            'image_url' => 'https://idcloudhost.com/wp-content/uploads/2020/11/free-178.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Kursus Public Speaking Series',
                'slug' => Str::slug('Kursus Public Speaking Series'),
                'description' => 'Public Speaking Series adalah program pembelajaran dan pelatihan yang dirancang untuk membangun kepercayaan diri dan keterampilan komunikasi di berbagai platform. Peserta akan mempelajari dasar-dasar public speaking, termasuk teknik copywriting, storytelling, dan lainnya.',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/portrait-handsome-man-black-suit-singing-song-holding-microphone-giving-speech-standing-against-white-background_1258-64790.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Kursus MC',
                'slug' => Str::slug('Kursus MC'),
                'description' => 'Kursus MC adalah program pembelajaran dan pelatihan yang dirancang untuk membangun kepercayaan diri dan keterampilan komunikasi di berbagai platform. Peserta akan mempelajari dasar-dasar MC, termasuk teknik copywriting, storytelling, dan lainnya.',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/attractive-man-smiling-smart-causual-dress-holding-microphone-giving-presentation-white-background_554837-627.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Kursus Podcaster',
                'slug' => Str::slug('Kursus Podcaster'),
                'description' => 'Kursus Podcaster adalah program pembelajaran dan pelatihan yang dirancang untuk membangun kepercayaan diri dan keterampilan komunikasi di berbagai platform. Peserta akan mempelajari dasar-dasar Podcaster, termasuk teknik copywriting, storytelling, dan lainnya.',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/asian-influencer-filming-headphones-review-podcast-episode-recording-recommendation-video-camera-live-broadcasting-talk-show-with-wireless-headset-product-social-media_482257-45961.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Kursus Livestreamer',
                'slug' => Str::slug('Kursus Livestreamer'),
                'description' => 'Kursus Livestreamer adalah program pembelajaran dan pelatihan yang dirancang untuk membangun kepercayaan diri dan keterampilan komunikasi di berbagai platform. Peserta akan mempelajari dasar-dasar Livestreamer, termasuk teknik copywriting, storytelling, dan lainnya.',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/asian-beautiful-asian-vloger-bloger-present-cloth-dress-online-business-shop-online-ideas-concept_609648-1772.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_id' => $programId,
                'name' => 'Kursus Voice Over',
                'slug' => Str::slug('Kursus Voice Over'),
                'description' => 'Kursus Voice Over adalah program pembelajaran dan pelatihan yang dirancang untuk membangun kepercayaan diri dan keterampilan komunikasi di berbagai platform. Peserta akan mempelajari dasar-dasar Voice Over, termasuk teknik copywriting, storytelling, dan lainnya.',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/close-up-woman-with-microphone_23-2149130791.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        // =====================================================
        // PROGRAM #4 - KURSUS CULINARY
        // =====================================================
        $programId = DB::table('programs')->insertGetId([
            'nama' => 'KURSUS CULINARY',
            'deskripsi' => 'KURSUS CULINARY',
            'image_url' => 'https://img.freepik.com/premium-photo/cooking-class-culinary-food-people-concept-group-friends-cooking-kitchen_178605-2890.jpg?semt=ais_hybrid&w=740',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Basic Cook',
                'slug' => Str::slug('Basic Cook'),
                'description' => 'Kursus Professional Cook dari VernonEdu dirancang untuk melatih peserta agar siap bekerja di lingkungan dapur profesional, bukan sekadar bisa memasak. Peserta akan belajar teknik dasar hingga lanjutan memasak, manajemen dapur, kebersihan, hingga ritme kerja cepat di industri kuliner. Dipandu oleh instruktur berpengalaman, pelatihan ini menggabungkan teori, praktik intensif, dan simulasi dapur nyata — agar kamu tidak hanya jago masak, tapi juga siap kerja sebagai cook di restoran, hotel, atau kitchen komersial lainnya.',
                'usia' => '15+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/premium-photo/portrait-young-teen-girl-cook-student-cooking-class-culinary-classroom-happy-young-woman-students-cooking-cooking-school_1421-12067.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Artisan Baker & Patissier',
                'slug' => Str::slug('Artisan Baker & Patissier'),
                'description' => 'Program Professional Baker dari VernonEdu dirancang untuk kamu yang ingin menekuni dunia baking secara serius dan profesional. Di sini, peserta akan belajar teknik membuat roti, cake, pastry, dan produk bakery lainnya — mulai dari dasar hingga ke tingkat lanjutan. Tak hanya soal rasa dan bentuk, kamu juga akan dilatih tentang konsistensi produksi, pengendalian bahan, serta ritme kerja di dapur bakery komersial. Dipandu oleh instruktur berpengalaman dan melalui banyak praktik langsung, program ini membekali kamu agar siap bekerja — atau bahkan membuka usaha sendiri — sebagai baker profesional.',
                'usia' => '15+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/happy-baker-with-freshly-baked-pastries_23-2151983454.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Professional Chef',
                'slug' => Str::slug('Professional Chef'),
                'description' => 'Program Professional Chef dari VernonEdu dirancang untuk kamu yang ingin naik level dari seorang cook menjadi pemimpin di dapur. Di sini, peserta tidak hanya mengasah keterampilan memasak tingkat lanjut, tapi juga belajar merancang menu, mengatur food cost, mengelola tim dapur, hingga membangun konsep dapur yang efisien dan kreatif. Dengan pendekatan praktik, studi kasus industri, dan mentorship dari chef berpengalaman, program ini mempersiapkan kamu untuk menjadi chef profesional yang tangguh, inovatif, dan siap memimpin di dapur mana pun.',
                'usia' => '15+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/portrait-beautiful-young-asian-chef-woman-with-spatula-yellow-isolated-background_74190-16157.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('sub_programs')->insert([
            [
                'program_id' => $programId,
                'name' => 'Chef Playground for kids, teens & Regular',
                'slug' => Str::slug('Chef Playground for kids, teens & Regular'),
                'description' => 'Ingin merasakan serunya masak di dapur ala profesional tanpa tekanan? Chef Playground adalah program cooking for fun dari VernonEdu yang dirancang untuk siapa saja yang ingin merasakan pengalaman memasak secara langsung. Di sini, peserta diajak bermain rasa, mencoba berbagai teknik masak, dan membuat hidangan spesial dengan panduan chef berpengalaman. Cocok untuk pemula, komunitas, hingga keluarga, Chef Playground bukan soal jadi ahli, tapi soal menikmati proses memasak dan pulang dengan pengalaman baru (dan perut kenyang!).',
                'usia' => '10+ tahun',
                'harga' => 1,
                'image_url' => 'https://img.magnific.com/free-photo/thoughtful-girl-cook-standing-with-ladle_23-2148085225.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =====================================================
        // PROGRAM #4 - KURSUS TECHNOLOGY
        // =====================================================
        $programId = DB::table('programs')->insertGetId([
            'nama' => 'KURSUS TECHNOLOGY',
            'deskripsi' => 'KURSUS TECHNOLOGY',
            'image_url' => 'https://img.magnific.com/free-photo/researcher-using-transparent-digital-tablet-screen-futuristic-technology_53876-101147.jpg?semt=ais_hybrid&w=740&q=80',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            'program_id' => $programId,
            'name' => 'Full Stack Developer',
            'slug' => Str::slug('Full Stack Developer'),
            'description' => 'Kursus Full Stack Developer dari VernonEdu membekalimu dengan kemampuan membangun aplikasi web dari ujung ke ujung — mulai dari tampilan antarmuka (front-end) hingga logika dan database (back-end). Belajar langsung lewat proyek nyata, kamu akan siap masuk dunia kerja sebagai developer yang serba bisa.',
            'usia' => '13+ tahun',
            'harga' => 1,
            'image_url' => 'https://img.magnific.com/premium-photo/male-freelancer-programming-server-encryption-firewall-software-using-security-network-interface-code-system-data-app-development-working-with-binary-code-text-script-program_482257-54516.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            'program_id' => $programId,
            'name' => 'Mobile App Developer',
            'slug' => Str::slug('Mobile App Developer'),
            'description' => 'Kursus Mobile App Developer with Flutter dari VernonEdu mengajarkan cara membangun aplikasi mobile modern dengan satu basis kode. Kamu akan belajar Flutter, desain antarmuka responsif, hingga menghubungkan ke API dan database — semuanya lewat proyek nyata. Cocok untuk kamu yang ingin jadi developer mobile yang efisien dan siap kerja.',
            'usia' => '13+ tahun',
            'harga' => 1,
            'image_url' => 'https://img.magnific.com/free-photo/representation-user-experience-interface-design_23-2150169865.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            'program_id' => $programId,
            'name' => 'Backend Developer',
            'slug' => Str::slug('Backend Developer'),
            'description' => 'Kursus Back-End Developer dari VernonEdu membekalimu dengan keterampilan merancang sistem, API, dan manajemen database yang menjadi tulang punggung aplikasi. Kamu akan belajar bahasa pemrograman seperti Python atau',
            'usia' => '15+ tahun',
            'harga' => 1,
            'image_url' => 'https://img.magnific.com/free-photo/coding-man_1098-18084.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('sub_programs')->insert([
            'program_id' => $programId,
            'name' => 'Web Developer',
            'slug' => Str::slug('Web Developer'),
            'description' => 'Kursus Web Developer dari VernonEdu cocok untuk kamu yang ingin menguasai pembuatan website dari',
            'usia' => '13+ tahun',
            'harga' => 1,
            'image_url' => 'https://img.magnific.com/free-vector/web-development-programmer-engineering-coding-website-augmented-reality-interface-screens-developer-project-engineer-programming-software-application-design-cartoon-illustration_107791-3863.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sub_programs')->insert([
            'program_id' => $programId,
            'name' => 'SQL Database',
            'slug' => Str::slug('SQL Database'),
            'description' => 'Kursus SQL Database dari VernonEdu dirancang untuk membantumu memahami cara menyimpan, mengelola, dan mengambil data dengan efisien menggunakan SQL. Mulai dari query dasar hingga',
            'usia' => '13+ tahun',
            'harga' => 1,
            'image_url' => 'https://img.magnific.com/free-vector/gradient-sql-illustration_23-2149247491.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
