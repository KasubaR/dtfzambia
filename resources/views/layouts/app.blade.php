<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- SEO / Meta --}}
    <title>@yield('title', config('app.name', 'Digital Future Labs'))</title>
    <meta name="description" content="@yield('meta_description', 'Digital Future Labs — empowering Zambian entrepreneurs and professionals with world-class digital skills training.')">
    <meta name="keywords"    content="@yield('meta_keywords', 'digital skills, training, Zambia, entrepreneurship, AI, web design, digital marketing')">

    {{-- Open Graph --}}
    <meta property="og:title"       content="@yield('og_title', config('app.name', 'Digital Future Labs'))" />
    <meta property="og:description" content="@yield('og_description', 'World-class digital skills training for Zambian entrepreneurs and professionals.')" />
    <meta property="og:type"        content="website" />
    <meta property="og:url"         content="{{ url()->current() }}" />
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')" />
    @endif

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />

    {{-- Compiled CSS (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Course card component styles --}}
    <link rel="stylesheet" href="{{ asset('css/course-card.css') }}" />

    {{-- Page-specific head content --}}
    @stack('head')
</head>
<body class="antialiased" style="background-color: var(--color-surface); color: var(--color-text);">

    {{-- ── Header ──────────────────────────────────────────── --}}
    @include('partials.header')

    {{-- ── Flash messages ──────────────────────────────────── --}}
    @if (session('success'))
        <div class="fixed top-20 right-4 z-[9999] max-w-sm px-5 py-3 rounded-lg shadow-lg text-sm font-semibold text-white"
             style="background-color: var(--color-green);"
             x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 4000)">
            <span class="material-symbols-outlined text-sm align-middle mr-1">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-20 right-4 z-[9999] max-w-sm px-5 py-3 rounded-lg shadow-lg text-sm font-semibold text-white"
             style="background-color: #b91c1c;">
            <span class="material-symbols-outlined text-sm align-middle mr-1">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Main content ─────────────────────────────────────── --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ── Footer ───────────────────────────────────────────── --}}
    @include('partials.footer')

    {{-- ── Page-specific scripts ───────────────────────────── --}}
    @stack('scripts')

</body>
</html>
