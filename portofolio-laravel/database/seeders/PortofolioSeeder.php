<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nama' => 'HTML/CSS', 'level' => 85],
            ['nama' => 'JavaScript', 'level' => 70],
            ['nama' => 'PHP', 'level' => 75],
            ['nama' => 'MySQL', 'level' => 65],
        ] as $skill) {
            Skill::query()->updateOrCreate(
                ['nama' => $skill['nama']],
                ['level' => $skill['level']],
            );
        }

        foreach ([
            [
                'posisi' => 'Pemateri TRM Goes To School',
                'perusahaan' => 'SMA Negeri 10 Surabaya',
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2025,
                'deskripsi' => 'Menyampaikan materi mengenai Teknologi Rekayasa Multimedia kepada siswa secara komunikatif dan interaktif. Membantu meningkatkan pemahaman siswa terkait dunia perkuliahan dan prospek di bidang multimedia, serta menyesuaikan penyampaian materi dengan audiens agar lebih mudah dipahami.',
            ],
            [
                'posisi' => 'Panitia PKKMB Divisi LO',
                'perusahaan' => 'Politeknik Elektronika Negeri Surabaya',
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2025,
                'deskripsi' => 'Mendukung kelancaran acara melalui koordinasi antar divisi dan penyampaian informasi yang efektif. Menyampaikan informasi teknis dan perubahan jadwal secara cepat dan jelas, serta memastikan kedisiplinan, kehadiran, dan kepatuhan peserta terhadap aturan kegiatan.',
            ],
            [
                'posisi' => 'Praktik Kerja Lapangan',
                'perusahaan' => 'Hotel Darmo',
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2026,
                'deskripsi' => 'Membantu proses produksi di bidang desain grafis seperti pembuatan logo, poster, dan materi visual lainnya. Terlibat juga dalam proses desain dan modeling 3D untuk kebutuhan presentasi maupun visualisasi produk.',
            ],
        ] as $experience) {
            Experience::query()->updateOrCreate(
                [
                    'posisi' => $experience['posisi'],
                    'perusahaan' => $experience['perusahaan'],
                ],
                $experience,
            );
        }
    }
}
