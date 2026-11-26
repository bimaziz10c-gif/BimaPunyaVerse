@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('header')
    <header class="admin-header">
        <div>
            <p class="admin-eyebrow">Kotak Masuk</p>
            <h1>Daftar Pesan Masuk</h1>
            <p>Pesan yang dikirim melalui formulir portofolio.</p>
        </div>
        <nav class="admin-nav" aria-label="Navigasi admin">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <form class="admin-nav-form" method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="admin-nav-logout" type="submit">Logout</button>
            </form>
        </nav>
    </header>
@endsection

@section('content')
    <section class="admin-message-list" aria-label="Daftar pesan masuk">
        @forelse ($messages as $message)
            <article class="admin-message">
                <header class="admin-message-header">
                    <div>
                        <strong>{{ $message->nama }}</strong>
                        <div class="admin-message-meta">{{ $message->email }}</div>
                    </div>
                    <span class="admin-message-date">{{ $message->tanggal }}</span>
                </header>
                @if ($message->subjek !== '')
                    <p class="admin-message-subject">Subjek: {{ $message->subjek }}</p>
                @endif
                <p class="admin-message-content">
                    {{ new \Illuminate\Support\HtmlString(nl2br(e($message->pesan))) }}
                </p>
            </article>
        @empty
            <p class="admin-empty">Belum ada pesan masuk.</p>
        @endforelse
    </section>
@endsection
