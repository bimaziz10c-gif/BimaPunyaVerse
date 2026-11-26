@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header')
    <header class="admin-header">
        <div>
            <p class="admin-eyebrow">Area Admin</p>
            <h1>Dashboard</h1>
            <p>Halo, {{ auth()->user()->name }}. Kelola konten portofolio di sini.</p>
        </div>
        <nav class="admin-nav" aria-label="Navigasi admin">
            <a href="{{ route('admin.messages') }}">Pesan Kontak</a>
            <form class="admin-nav-form" method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="admin-nav-logout" type="submit">Logout</button>
            </form>
        </nav>
    </header>
@endsection

@section('content')
    <section class="admin-card" aria-labelledby="skills-heading">
        <div class="admin-section-head">
            <div>
                <p class="admin-eyebrow">Konten Portofolio</p>
                <h2 id="skills-heading">Data Keahlian</h2>
            </div>
            <a class="admin-button" href="{{ route('admin.skills.create') }}">+ Tambah Skill</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Skill</th>
                        <th scope="col">Tingkat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skills as $index => $skill)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $skill->nama }}</td>
                            <td>{{ $skill->level }}%</td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.skills.edit', $skill) }}">Edit</a>
                                    <form class="admin-inline-form" method="post"
                                          action="{{ route('admin.skills.destroy', $skill) }}"
                                          onsubmit="return confirm('Hapus skill ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-button--danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-empty" colspan="4">Belum ada data keahlian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
