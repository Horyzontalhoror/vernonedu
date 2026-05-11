<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        $subPrograms = DB::table('sub_programs')->get();

        foreach ($subPrograms as $subProgram) {

            $materis = [];

            // =========================================
            // HABIT BUILDING
            // =========================================
            if ($subProgram->name === 'Habit Building') {

                $dataMateri = [
                    [
                        'judul' => 'Membangun Kebiasaan Positif',
                        'deskripsi' => 'Pengenalan pentingnya kebiasaan positif dalam kehidupan sehari-hari.'
                    ],
                    [
                        'judul' => 'Disiplin dan Tanggung Jawab',
                        'deskripsi' => 'Belajar disiplin waktu dan tanggung jawab terhadap tugas kecil.'
                    ],
                    [
                        'judul' => 'Kebiasaan Membaca',
                        'deskripsi' => 'Membangun budaya literasi dan membaca setiap hari.'
                    ],
                    [
                        'judul' => 'Manajemen Waktu Dasar',
                        'deskripsi' => 'Belajar mengatur waktu bermain, belajar, dan istirahat.'
                    ],
                    [
                        'judul' => 'Berpikir Positif',
                        'deskripsi' => 'Melatih pola pikir positif dalam menghadapi masalah.'
                    ],
                    [
                        'judul' => 'Kejujuran dalam Kehidupan',
                        'deskripsi' => 'Menanamkan nilai integritas dan kejujuran sejak dini.'
                    ],
                    [
                        'judul' => 'Kerja Sama Tim',
                        'deskripsi' => 'Belajar bekerja sama melalui permainan dan aktivitas kelompok.'
                    ],
                    [
                        'judul' => 'Empati dan Kepedulian',
                        'deskripsi' => 'Melatih rasa peduli terhadap keluarga dan teman.'
                    ],
                    [
                        'judul' => 'Mengelola Emosi',
                        'deskripsi' => 'Belajar mengenali dan mengontrol emosi dasar.'
                    ],
                    [
                        'judul' => 'Kebiasaan Hidup Sehat',
                        'deskripsi' => 'Membangun kebiasaan menjaga kesehatan tubuh.'
                    ],
                    [
                        'judul' => 'Berani Berbicara',
                        'deskripsi' => 'Melatih kepercayaan diri berbicara di depan orang lain.'
                    ],
                    [
                        'judul' => 'Growth Mindset Dasar',
                        'deskripsi' => 'Memahami bahwa kemampuan dapat berkembang dengan latihan.'
                    ],
                    [
                        'judul' => 'Menyelesaikan Masalah',
                        'deskripsi' => 'Belajar mencari solusi sederhana terhadap masalah sehari-hari.'
                    ],
                    [
                        'judul' => 'Belajar Konsisten',
                        'deskripsi' => 'Melatih konsistensi dalam menjalankan kebiasaan baik.'
                    ],
                    [
                        'judul' => 'Mini Project Karakter',
                        'deskripsi' => 'Menerapkan kebiasaan positif dalam proyek sederhana.'
                    ],
                    [
                        'judul' => 'Evaluasi dan Presentasi',
                        'deskripsi' => 'Review perkembangan kebiasaan dan presentasi hasil belajar.'
                    ],
                ];

            }

            // =========================================
            // MINDSET & CHARACTER BUILDING
            // =========================================
            elseif ($subProgram->name === 'Mindset & Character Building') {

                $dataMateri = [
                    [
                        'judul' => 'Pengenalan Growth Mindset',
                        'deskripsi' => 'Memahami konsep growth mindset dan fixed mindset.'
                    ],
                    [
                        'judul' => 'Self Awareness',
                        'deskripsi' => 'Belajar mengenali potensi dan kelemahan diri.'
                    ],
                    [
                        'judul' => 'Membangun Kepercayaan Diri',
                        'deskripsi' => 'Melatih keberanian mengambil keputusan dan tampil percaya diri.'
                    ],
                    [
                        'judul' => 'Komunikasi Efektif',
                        'deskripsi' => 'Belajar menyampaikan ide dengan baik dan sopan.'
                    ],
                    [
                        'judul' => 'Leadership Dasar',
                        'deskripsi' => 'Pengenalan kepemimpinan dalam aktivitas sehari-hari.'
                    ],
                    [
                        'judul' => 'Critical Thinking',
                        'deskripsi' => 'Melatih kemampuan berpikir kritis dan analitis.'
                    ],
                    [
                        'judul' => 'Problem Solving',
                        'deskripsi' => 'Belajar menyelesaikan masalah dengan pendekatan sistematis.'
                    ],
                    [
                        'judul' => 'Time Management',
                        'deskripsi' => 'Mengatur prioritas dan waktu secara efektif.'
                    ],
                    [
                        'judul' => 'Public Speaking',
                        'deskripsi' => 'Melatih kemampuan berbicara di depan umum.'
                    ],
                    [
                        'judul' => 'Agility Mindset',
                        'deskripsi' => 'Belajar beradaptasi dengan perubahan dan tantangan.'
                    ],
                    [
                        'judul' => 'Kolaborasi Tim',
                        'deskripsi' => 'Meningkatkan kemampuan bekerja dalam tim.'
                    ],
                    [
                        'judul' => 'Empati dan Emotional Intelligence',
                        'deskripsi' => 'Mengembangkan kecerdasan emosional dan empati sosial.'
                    ],
                    [
                        'judul' => 'Goal Setting',
                        'deskripsi' => 'Belajar membuat target dan langkah pencapaiannya.'
                    ],
                    [
                        'judul' => 'Personal Branding',
                        'deskripsi' => 'Membangun citra diri positif dan profesional.'
                    ],
                    [
                        'judul' => 'Project Character Building',
                        'deskripsi' => 'Penerapan nilai karakter dalam proyek nyata.'
                    ],
                    [
                        'judul' => 'Final Presentation & Evaluation',
                        'deskripsi' => 'Presentasi hasil pembelajaran dan evaluasi akhir program.'
                    ],
                ];

            }

            // =========================================
            // DEFAULT UNTUK SUB PROGRAM LAIN
            // =========================================
            else {

                $dataMateri = [];

                for ($i = 1; $i <= 16; $i++) {
                    $dataMateri[] = [
                        'judul' => 'Pertemuan ' . $i,
                        'deskripsi' => 'Materi pembelajaran pertemuan ke-' . $i,
                    ];
                }
            }

            // =========================================
            // INSERT KE DATABASE
            // =========================================
            foreach ($dataMateri as $index => $materi) {

                $materis[] = [
                    'sub_program_id' => $subProgram->id,
                    'judul' => $materi['judul'],
                    'deskripsi' => $materi['deskripsi'],
                    'urutan' => $index + 1,
                    'created_at' => now(),
                ];
            }

            DB::table('materis')->insert($materis);
        }
    }
}
