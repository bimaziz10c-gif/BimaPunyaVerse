<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\PesanKontak;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const PROFILE = [
        'nama' => 'Achmad Bima Aziz Muttaqi',
        'nik' => '5323600079',
        'prodi' => 'Teknologi Rekayasa Multimedia',
        'tagline' => 'Blom Kepikiran',
        'deskripsi' => 'raja iblis',
        'status' => true,
        'email' => 'bimaziz10c@email.com',
        'telepon' => '+62 812-122-488',
        'instagram' => 'https://www.instagram.com/',
        'github' => 'github.com/bibimverse',
        'ringkasan' => "Mahasiswa Teknologi Rekayasa Multimedia dengan minat pada pengembangan\nantarmuka web. Terbiasa menerjemahkan desain menjadi kode HTML5 dan CSS3 yang terstruktur,\nserta senang mempelajari pola layout modern seperti Flexbox dan CSS Grid. Sedang mencari\nkesempatan magang di tim front-end untuk mengasah kemampuan membangun produk digital yang nyata.",
    ];

    private const EDUCATION = [
        [
            'tahun' => '2025 – sekarang',
            'jenjang' => 'D4 Teknologi Rekayasa Multimedia',
            'institusi' => 'Politeknik Elektronika Negeri Surabaya',
            'deskripsi' => 'Mempelajari pengembangan web, desain, dan produksi multimedia.',
        ],
        [
            'tahun' => '2022 – 2025',
            'jenjang' => 'SMK Negeri 10 Surabaya',
            'institusi' => 'Jurusan Desain Komunikasi Visual',
            'deskripsi' => 'Mempelajari dasar desain grafis, tipografi, dan komunikasi visual.',
        ],
    ];

    private const PROJECTS = [
        [
            'judul' => 'Website CV & Portofolio',
            'kategori' => 'Web Development',
            'tahun' => 2026,
            'deskripsi' => 'Website portofolio pribadi dengan HTML5, CSS3, JavaScript, dan PHP Native yang dinamis.',
        ],
        [
            'judul' => 'Poster TRM Goes To School',
            'kategori' => 'Desain Grafis',
            'tahun' => 2025,
            'deskripsi' => 'Desain poster publikasi kegiatan sosialisasi program studi ke sekolah-sekolah.',
        ],
        [
            'judul' => 'Modeling 3D Visualisasi Produk',
            'kategori' => '3D Modeling',
            'tahun' => 2025,
            'deskripsi' => 'Pemodelan 3D produk untuk kebutuhan presentasi dan visualisasi saat PKL.',
        ],
        [
            'judul' => 'Logo Identitas Brand',
            'kategori' => 'Desain Grafis',
            'tahun' => 2024,
            'deskripsi' => 'Perancangan logo dan identitas visual sederhana untuk brand fiktif.',
        ],
    ];

    public function index(Request $request): View
    {
        $projects = self::PROJECTS;
        $categories = array_unique(array_column($projects, 'kategori'));
        sort($categories);

        $category = $request->query('kategori', 'semua');
        if (! is_string($category) || ($category !== 'semua' && ! in_array($category, $categories, true))) {
            $category = 'semua';
        }

        $keyword = $request->query('q', '');
        $keyword = is_string($keyword) ? trim($keyword) : '';

        $sort = $request->query('urut', 'terbaru');
        $sort = in_array($sort, ['terbaru', 'terlama'], true) ? $sort : 'terbaru';

        $filteredProjects = array_values(array_filter($projects, function (array $project) use ($category, $keyword): bool {
            $matchesCategory = $category === 'semua' || $project['kategori'] === $category;
            $matchesKeyword = $keyword === '' || stripos($project['judul'], $keyword) !== false;

            return $matchesCategory && $matchesKeyword;
        }));

        usort($filteredProjects, static function (array $left, array $right) use ($sort): int {
            return $sort === 'terlama'
                ? $left['tahun'] <=> $right['tahun']
                : $right['tahun'] <=> $left['tahun'];
        });

        $greetingName = $request->query('nama', '');

        return view('home', [
            ...self::PROFILE,
            'education' => self::EDUCATION,
            'skills' => Skill::query()->orderByDesc('level')->get(),
            'experiences' => Experience::query()->orderByDesc('tahun_mulai')->get(),
            'projects' => $projects,
            'categories' => $categories,
            'selectedCategory' => $category,
            'keyword' => $keyword,
            'sort' => $sort,
            'filteredProjects' => $filteredProjects,
            'isFiltered' => $category !== 'semua' || $keyword !== '',
            'greetingName' => is_string($greetingName) ? trim($greetingName) : '',
            'contactSent' => $request->session()->get('contact_sent'),
        ]);
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:150'],
            'email' => ['required', 'email', 'max:254'],
            'pesan' => ['required', 'string', 'min:10'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.min' => 'Pesan minimal 10 karakter.',
        ]);

        PesanKontak::query()->create([
            ...$validated,
            'subjek' => '',
        ]);

        return redirect()->route('home')->with('contact_sent', $validated);
    }
}
