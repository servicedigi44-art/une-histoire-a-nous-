@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Médias</h1>

<div class="bg-white rounded-xl border border-stone-200 p-6 mb-8 max-w-xl">
    <h2 class="text-sm font-medium mb-4">Ajouter un média</h2>
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm mb-1">Rattacher à un souvenir</label>
            <select name="memory_id" class="w-full rounded-md border-stone-300 text-sm">
                <option value="">— aucun —</option>
                @foreach ($memories as $memory)
                    <option value="{{ $memory->id }}">{{ $memory->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Rattacher à un ami (optionnel)</label>
            <select name="friend_id" class="w-full rounded-md border-stone-300 text-sm">
                <option value="">— aucun —</option>
                @foreach ($friends as $friend)
                    <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Type</label>
            <select name="type" class="w-full rounded-md border-stone-300 text-sm" required>
                <option value="image">Image</option>
                <option value="video">Vidéo</option>
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Rôle (pour les sliders avant/après, optionnel)</label>
            <select name="role" class="w-full rounded-md border-stone-300 text-sm">
                <option value="">— aucun —</option>
                <option value="before">Avant</option>
                <option value="after">Après</option>
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Fichier</label>
            <input type="file" name="file" class="w-full text-sm" required>
        </div>
        <div>
            <label class="block text-sm mb-1">Miniature (recommandé pour les vidéos)</label>
            <input type="file" name="thumbnail" class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm mb-1">Légende</label>
            <input type="text" name="caption" class="w-full rounded-md border-stone-300 text-sm">
        </div>
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Téléverser</button>
    </form>
</div>

<div class="grid sm:grid-cols-4 gap-4">
    @foreach ($media as $item)
        <div class="bg-white rounded-xl border border-stone-200 p-3">
            <div class="aspect-square bg-stone-100 rounded-md flex items-center justify-center text-xs text-stone-500 mb-2">
                {{ $item->type }}
            </div>
            <p class="text-xs text-stone-600 truncate">{{ $item->memory->title ?? '—' }}</p>
            <p class="text-xs text-stone-400 truncate">{{ $item->caption }}</p>
            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="mt-2" onsubmit="return confirm('Supprimer ce média ?');">
                @csrf @method('DELETE')
                <button class="text-xs text-red-600 hover:underline">Supprimer</button>
            </form>
        </div>
    @endforeach
</div>

<div class="mt-4">{{ $media->links() }}</div>
@endsection
