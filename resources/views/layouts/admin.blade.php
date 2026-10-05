<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration — Une histoire a nous</title>
    @vite(['resources/css/app.css', 'resources/js/admin/dashboard.js'])
</head>
<body class="bg-stone-100 text-stone-900 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-60 shrink-0 bg-stone-900 text-stone-200 p-5 space-y-1">
            <div class="text-lg font-semibold text-white mb-6">Administration</div>
            @php
                $links = [
                    'admin.dashboard' => ['/admin', 'Tableau de bord'],
                    'admin.slides.index' => [route('admin.slides.index'), 'Diaporama'],
                    'admin.friends.index' => [route('admin.friends.index'), 'Amis'],
                    'admin.messages.index' => [route('admin.messages.index'), 'Messages'],
                ];
            @endphp
            @foreach ($links as $name => [$url, $label])
                <a href="{{ $url }}"
                   class="block rounded-md px-3 py-2 text-sm {{ request()->routeIs($name) ? 'bg-amber-600 text-white' : 'hover:bg-stone-800' }}">
                    {{ $label }}
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button class="text-sm text-stone-400 hover:text-white">Se deconnecter</button>
            </form>
            <a href="{{ route('story.opening') }}" class="block text-xs text-stone-500 hover:text-stone-300 pt-2">
                ← Retour au site
            </a>
        </aside>

        <div class="flex-1 p-8">
            @if (session('status'))
                <div class="mb-6 rounded-md bg-emerald-100 text-emerald-800 px-4 py-2 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-md bg-red-100 text-red-800 px-4 py-3 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>