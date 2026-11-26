@extends('layouts.admin')

@section('title', 'Login Admin')
@section('shell-class', 'admin-shell--narrow')

@section('content')
    <div class="admin-login-brand">BIMA<span>.</span> / ADMIN</div>
    <section class="admin-card admin-login-card" aria-labelledby="login-heading">
        <p class="admin-eyebrow">Selamat datang kembali</p>
        <h1 id="login-heading">Login Admin</h1>

        @if ($errors->any())
            <p class="admin-alert" role="alert">{{ $errors->first() }}</p>
        @endif

        <form class="admin-form" method="post" action="{{ route('admin.login.store') }}">
            @csrf
            <label for="email">
                Email
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       autocomplete="username" required>
            </label>
            <label for="password">
                Password
                <input id="password" type="password" name="password"
                       autocomplete="current-password" required>
            </label>
            <div class="admin-form-actions">
                <button type="submit">Masuk ke Dashboard</button>
            </div>
        </form>
    </section>
@endsection
