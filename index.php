<?php

require_once __DIR__ . "/konfigurasi/koneksi.php";

function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function inputString(array $source, string $key, string $default = ''): string
{
    return isset($source[$key]) && is_string($source[$key]) ? $source[$key] : $default;
}

function aset($path)
{
    $file = __DIR__ . '/' . $path;
    return $path . '?v=' . (is_file($file) ? filemtime($file) : time());
}

// Kalimat perkenalan 
function greeting($nama)
{
    return "Halo, saya " . $nama;
}

// Teks status mahasiswa berdasarkan nilai boolean
function statusMahasiswa($status)
{
    if ($status) {
        return "Mahasiswa Aktif";
    } else {
        return "Bukan Mahasiswa Aktif";
    }
}


// Mengambil daftar kategori unik dari array project
function daftarKategori($projects)
{
    $kategori = array_unique(array_column($projects, 'kategori'));
    sort($kategori);
    return $kategori;
}

// Filter project berdasarkan kategori (GET) dan kata kunci judul (GET)
function filterProject($projects, $kategori, $kataKunci)
{
    $hasil = array_filter($projects, function ($p) use ($kategori, $kataKunci) {
        $cocokKategori = ($kategori === 'semua') || ($p['kategori'] === $kategori);
        $cocokJudul    = ($kataKunci === '') || (stripos($p['judul'], $kataKunci) !== false);
        return $cocokKategori && $cocokJudul;
    });
    return array_values($hasil);
}

// Urutkan project berdasarkan tahun: 'terbaru' (default) atau 'terlama'
function urutkanProject($projects, $arah = 'terbaru')
{
    usort($projects, function ($a, $b) use ($arah) {
        if ($arah === 'terlama') {
            return $a['tahun'] <=> $b['tahun'];
        }
        return $b['tahun'] <=> $a['tahun'];
    });
    return $projects;
}

// Validasi Contact Form, mengembalikan array pesan error (kosong = valid)
function validasiKontak($data)
{
    $errors = [];

    if ($data['nama'] === '') {
        $errors['nama'] = "Nama wajib diisi.";
    } elseif (mb_strlen($data['nama']) < 3) {
        $errors['nama'] = "Nama minimal 3 karakter.";
    }

    if ($data['email'] === '') {
        $errors['email'] = "Email wajib diisi.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid.";
    }


    if ($data['pesan'] === '') {
        $errors['pesan'] = "Pesan wajib diisi.";
    } elseif (mb_strlen($data['pesan']) < 10) {
        $errors['pesan'] = "Pesan minimal 10 karakter.";
    }

    return $errors;
}


/*DATA PROFIL*/
$nama      = "Achmad Bima Aziz Muttaqi";
$nik       = "5323600079";
$prodi     = "Teknologi Rekayasa Multimedia";
$tagline   = "Blom Kepikiran";
$deskripsi = "raja iblis";
$status    = true;
$email     = "bimaziz10c@email.com";
$telepon   = "+62 812-122-488";
$instagram = "https://www.instagram.com/";
$github    = "github.com/bibimverse";
$ringkasan = "Mahasiswa Teknologi Rekayasa Multimedia dengan minat pada pengembangan
antarmuka web. Terbiasa menerjemahkan desain menjadi kode HTML5 dan CSS3 yang terstruktur,
serta senang mempelajari pola layout modern seperti Flexbox dan CSS Grid. Sedang mencari
kesempatan magang di tim front-end untuk mengasah kemampuan membangun produk digital yang nyata.";


/*DATA ARRAY*/

// Skills 

$skills = [];
try {
    $resSkills = mysqli_query($koneksi, "SELECT nama_skill, tingkat FROM skills ORDER BY id ASC");
    while ($row = mysqli_fetch_assoc($resSkills)) {
        $skills[] = ["nama" => $row['nama_skill'], "level" => (int) $row['tingkat']];
    }
} catch (mysqli_sql_exception $exception) {
    error_log('Skills query failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Data keahlian tidak dapat dimuat.');
}

// Education
$education = [
    [
        "tahun"     => "2025 – sekarang",
        "jenjang"   => "D4 Teknologi Rekayasa Multimedia",
        "institusi" => "Politeknik Elektronika Negeri Surabaya",
        "deskripsi" => "Mempelajari pengembangan web, desain, dan produksi multimedia.",
    ],
    [
        "tahun"     => "2022 – 2025",
        "jenjang"   => "SMK Negeri 10 Surabaya",
        "institusi" => "Jurusan Desain Komunikasi Visual",
        "deskripsi" => "Mempelajari dasar desain grafis, tipografi, dan komunikasi visual.",
    ],
];

// Experience
$experience = [
    [
        "judul"     => "Pemateri TRM Goes To School",
        "deskripsi" => "Menyampaikan materi mengenai Teknologi Rekayasa Multimedia kepada siswa secara komunikatif dan interaktif. Membantu meningkatkan pemahaman siswa terkait dunia perkuliahan dan prospek di bidang multimedia, serta menyesuaikan penyampaian materi dengan audiens agar lebih mudah dipahami.",
    ],
    [
        "judul"     => "Panitia PKKMB Divisi LO",
        "deskripsi" => "Mendukung kelancaran acara melalui koordinasi antar divisi dan penyampaian informasi yang efektif. Menyampaikan informasi teknis dan perubahan jadwal secara cepat dan jelas, serta memastikan kedisiplinan, kehadiran, dan kepatuhan peserta terhadap aturan kegiatan.",
    ],
    [
        "judul"     => "Praktik Kerja Lapangan",
        "deskripsi" => "Membantu proses produksi di bidang desain grafis seperti pembuatan logo, poster, dan materi visual lainnya. Terlibat juga dalam proses desain dan modeling 3D untuk kebutuhan presentasi maupun visualisasi produk.",
    ],
];

// Projects
$projects = [
    [
        "judul"     => "Website CV & Portofolio",
        "kategori"  => "Web Development",
        "tahun"     => 2026,
        "deskripsi" => "Website portofolio pribadi dengan HTML5, CSS3, JavaScript, dan PHP Native yang dinamis.",
    ],
    [
        "judul"     => "Poster TRM Goes To School",
        "kategori"  => "Desain Grafis",
        "tahun"     => 2025,
        "deskripsi" => "Desain poster publikasi kegiatan sosialisasi program studi ke sekolah-sekolah.",
    ],
    [
        "judul"     => "Modeling 3D Visualisasi Produk",
        "kategori"  => "3D Modeling",
        "tahun"     => 2025,
        "deskripsi" => "Pemodelan 3D produk untuk kebutuhan presentasi dan visualisasi saat PKL.",
    ],

    [
        "judul"     => "Logo Identitas Brand",
        "kategori"  => "Desain Grafis",
        "tahun"     => 2024,
        "deskripsi" => "Perancangan logo dan identitas visual sederhana untuk brand fiktif.",
    ],
];


/*PROSES GET: filter, search, sort Project */
$semuaKategori = daftarKategori($projects);

$kategoriDipilih = inputString($_GET, 'kategori', 'semua');
if ($kategoriDipilih !== 'semua' && !in_array($kategoriDipilih, $semuaKategori, true)) {
    $kategoriDipilih = 'semua';
}

$kataKunci = trim(inputString($_GET, 'q'));

$urut = inputString($_GET, 'urut', 'terbaru');
if (!in_array($urut, ['terbaru', 'terlama'], true)) {
    $urut = 'terbaru';
}

$hasilProject = filterProject($projects, $kategoriDipilih, $kataKunci);
$hasilProject = urutkanProject($hasilProject, $urut);

$sedangFilter = ($kategoriDipilih !== 'semua') || ($kataKunci !== '');

// Tes form GET (Tugas Pendahuluan no. 7)
$namaPengunjung = trim(inputString($_GET, 'nama'));

/* PROSES POST */
$old = ["nama" => "", "email" => "", "subjek" => "", "pesan" => ""];
$errors = [];
$berhasil = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim'])) {
    $old = [
        "nama"   => trim(inputString($_POST, 'nama')),
        "email"  => trim(inputString($_POST, 'email')),
        "subjek" => trim(inputString($_POST, 'subjek')),
        "pesan"  => trim(inputString($_POST, 'pesan')),
    ];

    $errors = validasiKontak($old);

    if (empty($errors)) {
        try {
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO pesan_kontak (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $old['nama'],
                $old['email'],
                $old['subjek'],
                $old['pesan']
            );
            mysqli_stmt_execute($stmt);

            $berhasil = true;
            $dataTerkirim = $old;
            $old = ["nama" => "", "email" => "", "subjek" => "", "pesan" => ""];
        } catch (mysqli_sql_exception $exception) {
            error_log('Contact message insert failed: ' . $exception->getMessage());
            $errors['pesan'] = "Pesan gagal disimpan, coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($nama) ?> — CV & Portofolio</title>
    <!-- Terapkan tema tersimpan sebelum halaman digambar (mencegah kedip putih) -->
    <script>
        (function () {
            try {
                var tersimpan = localStorage.getItem("tema");
                var gelap = tersimpan
                    ? tersimpan === "dark"
                    : window.matchMedia("(prefers-color-scheme: dark)").matches;
                document.documentElement.setAttribute("data-theme", gelap ? "dark" : "light");
            } catch (e) {
                document.documentElement.setAttribute("data-theme", "light");
            }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= e(aset('aset/css/style.css')) ?>">
</head>

<body>

    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="site-nav">
        <div class="nav-inner">
            <span class="nav-mark">bibimverse<span class="nav-mark-dot">.</span></span>
            <div class="nav-right">
                <nav aria-label="Navigasi utama">
                    <ul>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#skill">Skill</a></li>
                        <li><a href="#pendidikan">Pendidikan</a></li>
                        <li><a href="#pengalaman">Pengalaman</a></li>
                        <li><a href="#project">Project</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </nav>

                <!-- Tombol mode gelap / terang -->
                <button id="themeToggle" class="theme-toggle" type="button"
                    aria-label="Ganti ke mode gelap" aria-pressed="false" title="Ganti tema">
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z" />
                    </svg>
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main id="main">

    <!-- ===== HOME ===== -->
    <section class="hero" id="home">
        <div class="hero-grid">
            <div class="hero-text">
                <p class="hero-eyebrow">Portofolio</p>
                <h1><?= e($nama) ?></h1>
                <h2 class="hero-greeting"><?= e(greeting($nama)) ?></h2>
                <p class="hero-role"><?= e($tagline) ?></p>
                <p class="hero-desc"><?= e($deskripsi) ?></p>
                <p class="hero-desc"><?= e($prodi) ?> &middot; NIK <?= e($nik) ?></p>
                <div class="hero-actions">
                    <a href="#kontak" class="btn btn-primary">Hubungi Saya</a>
                    <a href="#" class="btn btn-ghost">Unduh CV (PDF)</a>
                </div>
            </div>

            <div class="hero-figure">
                <div class="figure-frame">
                    <img class="photo-placeholder" src="aset/img/profil.jpeg"
                        alt="Foto <?= e($nama) ?>">
                    <span class="figure-tag">Wujud Asli Raja Iblis</span>
                </div>
                <span class="status-badge">Marvel Studio olong Lirik Aku</span>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT ME ===== -->
    <section id="tentang" class="section">
        <div class="section-head">
            <span class="section-index">01</span>
            <h2>Profil Saya</h2>
        </div>

        <div class="about-grid">
            <p class="section-lead"><?= e($ringkasan) ?></p>

            <ul class="info-list">
                <li><span class="contact-label">Nama</span><span><?= e($nama) ?></span></li>
                <li><span class="contact-label">NIK</span><span><?= e($nik) ?></span></li>
                <li><span class="contact-label">Prodi</span><span><?= e($prodi) ?></span></li>
                <li>
                    <span class="contact-label">Status</span>
                    <?php if ($status): ?>
                        <span class="status-pill pill-aktif"><?= e(statusMahasiswa($status)) ?></span>
                    <?php else: ?>
                        <span class="status-pill pill-nonaktif"><?= e(statusMahasiswa($status)) ?></span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>

        <!-- Tes form GET -->
        <form action="index.php#tentang" method="GET" class="greet-form">
            <label for="namaPengunjung">Sapa saya:</label>
            <input type="text" id="namaPengunjung" name="nama" placeholder="Masukkan nama Anda"
                value="<?= e($namaPengunjung) ?>">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        <?php if (isset($_GET['nama']) && $namaPengunjung !== ''): ?>
            <p class="greet-result">Halo, <?= e($namaPengunjung) ?>! Selamat datang di portfolio saya.</p>
        <?php endif; ?>
    </section>


    
    <!-- ===== SKILLS ===== -->
    <section id="skill" class="section section-alt">
        <div class="section-head">
            <span class="section-index">02</span>
            <h2>Keahlian</h2>
        </div>

        <div class="skill-grid">
            <?php foreach ($skills as $skill): ?>
                <div class="skill-card">
                    <div class="skill-top">
                        <span><?= e($skill['nama']) ?></span>
                        <span><?= (int) $skill['level'] ?>%</span>
                    </div>
                    <div class="skill-track">
                        <div class="skill-fill" style="width:<?= (int) $skill['level'] ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===== EDUCATION ===== -->
    <section id="pendidikan" class="section">
        <div class="section-head">
            <span class="section-index">03</span>
            <h2>Riwayat Pendidikan</h2>
        </div>

        <div class="timeline">
            <?php foreach ($education as $edu): ?>
                <div class="timeline-item">
                    <span class="timeline-dot"></span>
                    <div class="timeline-card">
                        <span class="timeline-year"><?= e($edu['tahun']) ?></span>
                        <h3><?= e($edu['jenjang']) ?></h3>
                        <p><strong><?= e($edu['institusi']) ?></strong> &mdash; <?= e($edu['deskripsi']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===== EXPERIENCE ===== -->
    <section id="pengalaman" class="section section-alt">
        <div class="section-head">
            <span class="section-index">04</span>
            <h2>Pengalaman &amp; Organisasi</h2>
        </div>

        <div class="card-grid">
            <?php foreach ($experience as $exp): ?>
                <article class="exp-card">
                    <h3><?= e($exp['judul']) ?></h3>
                    <p><?= e($exp['deskripsi']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===== PROJECTS ===== -->
    <section id="project" class="section">
        <div class="section-head">
            <span class="section-index">05</span>
            <h2>Project</h2>
        </div>

        <!-- Filter + Search + Sort (GET) -->
        <form action="index.php#project" method="GET" class="project-toolbar">
            <div class="field">
                <label for="q">Cari judul</label>
                <input type="text" id="q" name="q" placeholder="Ketik judul project..."
                    value="<?= e($kataKunci) ?>">
            </div>

            <div class="field">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori">
                    <option value="semua">Semua kategori</option>
                    <?php foreach ($semuaKategori as $kat): ?>
                        <option value="<?= e($kat) ?>" <?= $kat === $kategoriDipilih ? 'selected' : '' ?>>
                            <?= e($kat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="toolbar-actions">
                <button type="submit" class="btn btn-primary">Terapkan</button>
                <?php if ($sedangFilter || $urut !== 'terbaru'): ?>
                    <a href="index.php#project" class="btn btn-outline">Reset</a>
                <?php endif; ?>
            </div>
        </form>

        <p class="result-info">
            Menampilkan <strong><?= count($hasilProject) ?></strong> dari <?= count($projects) ?> project
            <?php if ($kategoriDipilih !== 'semua'): ?>
                &middot; kategori <strong><?= e($kategoriDipilih) ?></strong>
            <?php endif; ?>
            <?php if ($kataKunci !== ''): ?>
                &middot; kata kunci &ldquo;<strong><?= e($kataKunci) ?></strong>&rdquo;
            <?php endif; ?>
        </p>

        <?php if (count($hasilProject) > 0): ?>
            <div class="project-grid">
                <?php foreach ($hasilProject as $p): ?>
                    <article class="project-card">
                        <div class="project-meta">
                            <span class="chip"><?= e($p['kategori']) ?></span>
                            <span class="project-year"><?= (int) $p['tahun'] ?></span>
                        </div>
                        <h3><?= e($p['judul']) ?></h3>
                        <p><?= e($p['deskripsi']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>Project tidak ditemukan</h3>
                <p>Tidak ada project yang cocok dengan filter atau kata kunci yang kamu pilih.
                    Coba ubah kata kunci atau pilih kategori lain.</p>
                <a href="index.php#project" class="btn btn-primary">Tampilkan semua project</a>
            </div>
        <?php endif; ?>
    </section>

    <!-- ===== CONTACT ===== -->
    <section id="kontak" class="section section-alt contact">
        <div class="section-head">
            <span class="section-index">06</span>
            <h2>Kontak</h2>
        </div>

        <div class="contact-grid">
            <div>
                <ul class="contact-list">
                    <li><span class="contact-label">Email</span><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></li>
                    <li><span class="contact-label">Telepon</span><a href="tel:<?= e(preg_replace('/[^+0-9]/', '', $telepon)) ?>"><?= e($telepon) ?></a></li>
                    <li><span class="contact-label">Instagram</span><a href="<?= e($instagram) ?>"><?= e($instagram) ?></a></li>
                </ul>

                <div class="contact-note">
                    <p>Terbuka untuk diskusi peluang magang, proyek freelance, atau sekadar
                        bertukar pikiran soal Perkuliahan</p>
                </div>
            </div>

            <!-- Contact Form (POST + validasi) -->
            <div class="form-wrap">
                <?php if ($berhasil): ?>
                    <div class="alert alert-success" role="status">
                        <strong>Pesan berhasil dikirim!</strong>
                        <p>Terima kasih, <?= e($dataTerkirim['nama']) ?>. Berikut data yang kamu kirim:</p>
                        <ul>
                            <li>Email: <?= e($dataTerkirim['email']) ?></li>
                            
                            <li>Pesan: <?= nl2br(e($dataTerkirim['pesan'])) ?></li>
                        </ul>
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="alert alert-error" role="alert">
                        <strong>Pesan belum terkirim.</strong> Periksa kembali isian yang ditandai di bawah ini.
                    </div>
                <?php endif; ?>

                <form action="index.php#kontak" method="POST" class="contact-form" novalidate>
                    <div class="field <?= isset($errors['nama']) ? 'has-error' : '' ?>">
                        <label for="k-nama">Nama</label>
                        <input type="text" id="k-nama" name="nama" placeholder="Nama lengkap"
                            value="<?= e($old['nama']) ?>">
                        <?php if (isset($errors['nama'])): ?>
                            <span class="field-error"><?= e($errors['nama']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="field <?= isset($errors['email']) ? 'has-error' : '' ?>">
                        <label for="k-email">Email</label>
                        <input type="email" id="k-email" name="email" placeholder="nama@email.com"
                            value="<?= e($old['email']) ?>">
                        <?php if (isset($errors['email'])): ?>
                            <span class="field-error"><?= e($errors['email']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="field <?= isset($errors['pesan']) ? 'has-error' : '' ?>">
                        <label for="k-pesan">Pesan</label>
                        <textarea id="k-pesan" name="pesan" rows="5"
                            placeholder="Tulis pesanmu di sini..."><?= e($old['pesan']) ?></textarea>
                        <?php if (isset($errors['pesan'])): ?>
                            <span class="field-error"><?= e($errors['pesan']) ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="kirim" value="1" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    </main>

    <footer class="site-footer">
        <p>&copy; <?= date("Y") ?> &mdash; <?= e($nama) ?></p>
    </footer>

    <script>
        // =====================================================
        // Mode gelap / terang (tema awal sudah dipasang di <head>)
        // =====================================================
        (function () {
            const root = document.documentElement;
            const tombolTema = document.getElementById("themeToggle");

            function temaSaatIni() {
                return root.getAttribute("data-theme") === "dark" ? "dark" : "light";
            }

            function terapkanTema(tema) {
                root.setAttribute("data-theme", tema);

                if (tombolTema) {
                    const gelap = tema === "dark";
                    tombolTema.setAttribute("aria-pressed", String(gelap));
                    tombolTema.setAttribute(
                        "aria-label",
                        gelap ? "Ganti ke mode terang" : "Ganti ke mode gelap"
                    );
                }
            }

            function simpanTema(tema) {
                try {
                    localStorage.setItem("tema", tema);
                } catch (e) {
                    // localStorage bisa diblokir (mode privat); tema tetap berlaku untuk sesi ini
                }
            }

            // sinkronkan status tombol dengan tema yang sudah dipasang di <head>
            terapkanTema(temaSaatIni());

            if (tombolTema) {
                tombolTema.addEventListener("click", function () {
                    const baru = temaSaatIni() === "dark" ? "light" : "dark";
                    terapkanTema(baru);
                    simpanTema(baru);
                });
            }

            // Jika pengguna belum pernah memilih, ikuti perubahan tema sistem
            const queryGelap = window.matchMedia("(prefers-color-scheme: dark)");
            queryGelap.addEventListener("change", function (event) {
                let sudahMemilih = false;
                try {
                    sudahMemilih = localStorage.getItem("tema") !== null;
                } catch (e) { }

                if (!sudahMemilih) {
                    terapkanTema(event.matches ? "dark" : "light");
                }
            });

            // ---- Pendeteksi style.css lama: banner hanya muncul jika file CSS belum versi terbaru.
            //      Boleh dihapus kalau fitur tema sudah berjalan.
            window.addEventListener("load", function () {
                var varHero = getComputedStyle(document.documentElement).getPropertyValue("--hero-bg");
                if (varHero.trim() !== "") return;

                var banner = document.createElement("div");
                banner.setAttribute("role", "alert");
                banner.style.cssText = "position:fixed;left:0;right:0;bottom:0;z-index:9999;padding:12px 16px;" +
                    "background:#7A2623;color:#fff;font:14px/1.5 sans-serif;text-align:center;";
                banner.textContent = "Fitur tema belum aktif: style.css masih versi lama. " +
                    "Timpa aset/css/style.css dengan versi terbaru, lalu tekan Ctrl+F5.";
                document.body.appendChild(banner);
            });
        })();
    </script>
</body>

</html>