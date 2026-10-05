<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — Une histoire à nous</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-black text-stone-100 flex items-center justify-center font-serif px-4">
    <div class="w-full max-w-sm">
        <h1 class="text-2xl text-center mb-1 tracking-wide">Une histoire à nous</h1>
        <p class="text-center text-stone-400 text-sm mb-8">Un espace privé, rien que pour nous.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-900/40 border border-red-700 text-red-200 px-4 py-2 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-stone-400 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-md bg-stone-900 border border-stone-700 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <div>
                <label class="block text-xs text-stone-400 mb-1">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full rounded-md bg-stone-900 border border-stone-700 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-600">
            </div>
            <label class="flex items-center gap-2 text-xs text-stone-400">
                <input type="checkbox" name="remember" class="rounded">
                Se souvenir de moi
            </label>
            <button type="submit"
                    class="w-full rounded-md bg-amber-700 hover:bg-amber-600 transition text-white text-sm py-2.5">
                Entrer
            </button>
        </form>
    </div>
</body>
</html>
