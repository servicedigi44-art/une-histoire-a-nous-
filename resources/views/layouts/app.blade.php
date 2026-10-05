<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteTitle ?? 'Une histoire a nous')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-black text-stone-100 font-serif antialiased selection:bg-amber-200/30">
    @if (session('status'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-800/90 text-white px-4 py-2 rounded-lg shadow-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <main class="min-h-screen">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @auth
        <form method="POST" action="{{ route('logout') }}" class="fixed top-4 left-4 z-40">
            @csrf
            <button class="text-sm font-semibold text-white">Se deconnecter</button>
        </form>
    @endauth
</body>
</html>