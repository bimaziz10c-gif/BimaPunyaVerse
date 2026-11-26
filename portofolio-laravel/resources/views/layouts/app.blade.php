<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
