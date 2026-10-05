@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Capsules temporelles</h1>

<div class="bg-white rounded-xl border border-stone-200 p-6 mb-8 max-w-xl">
    <h2 class="text-sm font-medium mb-4">Ajouter une capsule</h2>
    <form method="POST" action="{{ route('admin.capsules.store') }}" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm mb-1">Ami</label>
            <select name="friend_id" class="w-full rounded-md border-stone-300 text-sm" required>
                @foreach ($friends as $friend)
                    <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Message</label>
            <textarea name="content" rows="3" class="w-full rounded-md border-stone-300 text-sm" required></textarea>
        </div>
        <div>
            <label class="block text-sm mb-1">Date et heure d'ouverture</label>
            <input type="datetime-local" name="unlock_at" class="w-full rounded-md border-stone-300 text-sm" required>
        </div>
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Créer la capsule</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-stone-200 divide-y">
    @foreach ($capsules as $capsule)
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="text-sm">{{ $capsule->friend->name }}</p>
                <p class="text-xs text-stone-500">
                    Ouverture : {{ $capsule->unlock_at->format('d/m/Y H:i') }}
                    — {{ $capsule->isOpen() ? '🔓 ouverte' : '🔒 verrouillée' }}
                </p>
            </div>
            <form method="POST" action="{{ route('admin.capsules.destroy', $capsule) }}" onsubmit="return confirm('Supprimer cette capsule ?');">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:underline text-sm">Supprimer</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
