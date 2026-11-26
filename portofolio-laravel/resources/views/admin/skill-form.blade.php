@extends('layouts.admin')

@section('title', $skill->exists ? 'Edit Keahlian' : 'Tambah Keahlian')
@section('shell-class', 'admin-shell--narrow')

@section('header')
    <header class="admin-header">
        <div>
            <p class="admin-eyebrow">Konten Portofolio</p>
            <h1>{{ $skill->exists ? 'Edit Keahlian' : 'Tambah Keahlian' }}</h1>
        </div>
        <nav class="admin-nav" aria-label="Navigasi admin">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </nav>
    </header>
@endsection

@section('content')
    <section class="admin-card">
        @if ($errors->any())
            <p class="admin-alert" role="alert">{{ $errors->first() }}</p>
        @endif

        <form class="admin-form" method="post"
              action="{{ $skill->exists ? route('admin.skills.update', $skill) : route('admin.skills.store') }}">
            @csrf
            @if ($skill->exists)
                @method('PUT')
            @endif
            <label for="nama_skill">
                Nama keahlian
                <input id="nama_skill" type="text" name="nama_skill"
                       value="{{ old('nama_skill', $skill->nama) }}" required>
            </label>
            <label for="tingkat">
                Tingkat keahlian (%)
                <input id="tingkat" type="number" name="tingkat" min="0" max="100"
                       value="{{ old('tingkat', $skill->level ?? 50) }}" required>
            </label>
            <div class="admin-form-actions">
                <button type="submit">Simpan</button>
                <a class="admin-button admin-button--quiet" href="{{ route('admin.dashboard') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
