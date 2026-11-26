@extends('layouts.app')

@section('title', $nama . ' — CV & Portofolio')

@section('content')
<main id="main">

    <!-- ===== HOME ===== -->
    <section class="hero" id="home">
        <div class="hero-grid">
            <div class="hero-text">
                <p class="hero-eyebrow">Portofolio</p>
                <h1>{{ $nama }}</h1>
                <h2 class="hero-greeting">{{ 'Halo, saya ' . $nama }}</h2>
                <p class="hero-role">{{ $tagline }}</p>
                <p class="hero-desc">{{ $deskripsi }}</p>
                <p class="hero-desc">{{ $prodi }} &middot; NIK {{ $nik }}</p>
                <div class="hero-actions">
                    <a href="#kontak" class="btn btn-primary">Hubungi Saya</a>
                    <a href="#" class="btn btn-ghost">Unduh CV (PDF)</a>
                </div>
            </div>

            <div class="hero-figure">
                <div class="figure-frame">
                    <img class="photo-placeholder" src="{{ asset('img/profil.jpeg') }}"
                        alt="Foto {{ $nama }}">
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
            <p class="section-lead">{{ $ringkasan }}</p>

            <ul class="info-list">
                <li><span class="contact-label">Nama</span><span>{{ $nama }}</span></li>
                <li><span class="contact-label">NIK</span><span>{{ $nik }}</span></li>
                <li><span class="contact-label">Prodi</span><span>{{ $prodi }}</span></li>
                <li>
                    <span class="contact-label">Status</span>
                    @if ($status)
                        <span class="status-pill pill-aktif">Mahasiswa Aktif</span>
                    @else
                        <span class="status-pill pill-nonaktif">Bukan Mahasiswa Aktif</span>
                    @endif
                </li>
            </ul>
        </div>

        <!-- Tes form GET -->
        <form action="{{ route('home') }}#tentang" method="GET" class="greet-form">
            <label for="namaPengunjung">Sapa saya:</label>
            <input type="text" id="namaPengunjung" name="nama" placeholder="Masukkan nama Anda"
                value="{{ $greetingName }}">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        @if ($greetingName !== '')
            <p class="greet-result">Halo, {{ $greetingName }}! Selamat datang di portfolio saya.</p>
        @endif
    </section>


    
    <!-- ===== SKILLS ===== -->
    <section id="skill" class="section section-alt">
        <div class="section-head">
            <span class="section-index">02</span>
            <h2>Keahlian</h2>
        </div>

        <div class="skill-grid">
            @forelse ($skills as $skill)
                <div class="skill-card">
                    <div class="skill-top">
                        <span>{{ $skill->nama }}</span>
                        <span>{{ (int) $skill->level }}%</span>
                    </div>
                    <div class="skill-track">
                        <div class="skill-fill" style="width:{{ (int) $skill->level }}%"></div>
                    </div>
                </div>
            @empty
                <p>Belum ada data keahlian.</p>
            @endforelse
        </div>
    </section>

    <!-- ===== EDUCATION ===== -->
    <section id="pendidikan" class="section">
        <div class="section-head">
            <span class="section-index">03</span>
            <h2>Riwayat Pendidikan</h2>
        </div>

        <div class="timeline">
            @foreach ($education as $edu)
                <div class="timeline-item">
                    <span class="timeline-dot"></span>
                    <div class="timeline-card">
                        <span class="timeline-year">{{ $edu['tahun'] }}</span>
                        <h3>{{ $edu['jenjang'] }}</h3>
                        <p><strong>{{ $edu['institusi'] }}</strong> &mdash; {{ $edu['deskripsi'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ===== EXPERIENCE ===== -->
    <section id="pengalaman" class="section section-alt">
        <div class="section-head">
            <span class="section-index">04</span>
            <h2>Pengalaman &amp; Organisasi</h2>
        </div>

        <div class="card-grid">
            @forelse ($experiences as $experience)
                <article class="exp-card">
                    <h3>{{ $experience->posisi }}</h3>
                    <p><strong>{{ $experience->perusahaan }}</strong>
                        &middot; {{ $experience->tahun_mulai }}@if ($experience->tahun_selesai)–{{ $experience->tahun_selesai }}@endif
                    </p>
                    @if ($experience->deskripsi)
                        <p>{{ $experience->deskripsi }}</p>
                    @endif
                </article>
            @empty
                <p>Belum ada data pengalaman.</p>
            @endforelse
        </div>
    </section>

    <!-- ===== PROJECTS ===== -->
    <section id="project" class="section">
        <div class="section-head">
            <span class="section-index">05</span>
            <h2>Project</h2>
        </div>

        <!-- Filter + Search + Sort (GET) -->
        <form action="{{ route('home') }}#project" method="GET" class="project-toolbar">
            <div class="field">
                <label for="q">Cari judul</label>
                <input type="text" id="q" name="q" placeholder="Ketik judul project..."
                    value="{{ $keyword }}">
            </div>

            <div class="field">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori">
                    <option value="semua">Semua kategori</option>
                    @foreach ($categories as $kat)
                        <option value="{{ $kat }}" {{ $kat === $selectedCategory ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="toolbar-actions">
                <button type="submit" class="btn btn-primary">Terapkan</button>
                @if ($isFiltered || $sort !== 'terbaru')
                    <a href="{{ route('home') }}#project" class="btn btn-outline">Reset</a>
                @endif
            </div>
        </form>

        <p class="result-info">
            Menampilkan <strong>{{ count($filteredProjects) }}</strong> dari {{ count($projects) }} project
            @if ($selectedCategory !== 'semua')
                &middot; kategori <strong>{{ $selectedCategory }}</strong>
            @endif
            @if ($keyword !== '')
                &middot; kata kunci &ldquo;<strong>{{ $keyword }}</strong>&rdquo;
            @endif
        </p>

        @if (count($filteredProjects) > 0)
            <div class="project-grid">
                @foreach ($filteredProjects as $p)
                    <article class="project-card">
                        <div class="project-meta">
                            <span class="chip">{{ $p['kategori'] }}</span>
                            <span class="project-year">{{ (int) $p['tahun'] }}</span>
                        </div>
                        <h3>{{ $p['judul'] }}</h3>
                        <p>{{ $p['deskripsi'] }}</p>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Project tidak ditemukan</h3>
                <p>Tidak ada project yang cocok dengan filter atau kata kunci yang kamu pilih.
                    Coba ubah kata kunci atau pilih kategori lain.</p>
                <a href="{{ route('home') }}#project" class="btn btn-primary">Tampilkan semua project</a>
            </div>
        @endif
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
                    <li><span class="contact-label">Email</span><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                    <li><span class="contact-label">Telepon</span><a href="tel:{{ preg_replace('/[^+0-9]/', '', $telepon) }}">{{ $telepon }}</a></li>
                    <li><span class="contact-label">Instagram</span><a href="{{ $instagram }}">{{ $instagram }}</a></li>
                </ul>

                <div class="contact-note">
                    <p>Terbuka untuk diskusi peluang magang, proyek freelance, atau sekadar
                        bertukar pikiran soal Perkuliahan</p>
                </div>
            </div>

            <!-- Contact Form (POST + validasi) -->
            <div class="form-wrap">
                @if (!empty($contactSent))
                    <div class="alert alert-success" role="status">
                        <strong>Pesan berhasil dikirim!</strong>
                        <p>Terima kasih, {{ $contactSent['nama'] }}. Berikut data yang kamu kirim:</p>
                        <ul>
                            <li>Email: {{ $contactSent['email'] }}</li>
                            
                            <li>Pesan: {{ new \Illuminate\Support\HtmlString(nl2br(e($contactSent['pesan']))) }}</li>
                        </ul>
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <strong>Pesan belum terkirim.</strong> Periksa kembali isian yang ditandai di bawah ini.
                    </div>
                @endif

                <form action="{{ route('contact.store') }}#kontak" method="POST" class="contact-form" novalidate>
                    @csrf
                    <div class="field {{ $errors->has('nama') ? 'has-error' : '' }}">
                        <label for="k-nama">Nama</label>
                        <input type="text" id="k-nama" name="nama" placeholder="Nama lengkap"
                            value="{{ old('nama') }}">
                        @if ($errors->has('nama'))
                            <span class="field-error">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="k-email">Email</label>
                        <input type="email" id="k-email" name="email" placeholder="nama@email.com"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="field-error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('pesan') ? 'has-error' : '' }}">
                        <label for="k-pesan">Pesan</label>
                        <textarea id="k-pesan" name="pesan" rows="5"
                            placeholder="Tulis pesanmu di sini...">{{ old('pesan') }}</textarea>
                        @if ($errors->has('pesan'))
                            <span class="field-error">{{ $errors->first('pesan') }}</span>
                        @endif
                    </div>

                    <button type="submit" name="kirim" value="1" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    </main>
@endsection
