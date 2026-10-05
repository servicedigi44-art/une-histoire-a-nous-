@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">{{ $memory->exists ? 'Modifier le souvenir' : 'Nouveau souvenir' }}</h1>

<form method="POST"
      action="{{ $memory->exists ? route('admin.memories.update', $memory) : route('admin.memories.store') }}"
      class="bg-white rounded-xl border border-stone-200 p-6 space-y-4 max-w-xl">
    @csrf
    @if ($memory->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm mb-1">Chapitre</label>
        <select name="chapter_id" class="w-full rounded-md border-stone-300 text-sm" required>
            @foreach ($chapters as $chapter)
                <option value="{{ $chapter->id }}" {{ old('chapter_id', $memory->chapter_id) == $chapter->id ? 'selected' : '' }}>
                    #{{ $chapter->number }} — {{ $chapter->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm mb-1">Année</label>
        <input type="number" name="year" value="{{ old('year', $memory->year) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <div>
        <label class="block text-sm mb-1">Titre</label>
        <input type="text" name="title" value="{{ old('title', $memory->title) }}" class="w-full rounded-md border-stone-300 text-sm" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-md border-stone-300 text-sm">{{ old('description', $memory->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm mb-1">Anecdote ("Vous souvenez-vous de ce jour ?")</label>
        <textarea name="anecdote" rows="3" class="w-full rounded-md border-stone-300 text-sm">{{ old('anecdote', $memory->anecdote) }}</textarea>
    </div>
    <div>
        <label class="block text-sm mb-1">Type</label>
        <select name="memory_type" class="w-full rounded-md border-stone-300 text-sm">
            @foreach (['photo','video','timeline','before_after','special'] as $type)
                <option value="{{ $type }}" {{ old('memory_type', $memory->memory_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm mb-1">Catégorie (dossier du chapitre 3, facultatif)</label>
        <input type="text" name="category" value="{{ old('category', $memory->category) }}" class="w-full rounded-md border-stone-300 text-sm" placeholder="ex: Les poses">
    </div>
    <div>
        <label class="block text-sm mb-1">Ordre d'affichage</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $memory->sort_order) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $memory->is_featured) ? 'checked' : '' }}>
        Souvenir mis en avant
    </label>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $memory->is_active) ? 'checked' : '' }}>
        Visible pour les visiteurs
    </label>

    <div class="pt-2">
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Enregistrer</button>
        <a href="{{ route('admin.memories.index') }}" class="ml-3 text-sm text-stone-500">Annuler</a>
    </div>
</form>

@if ($memory->exists)
    <div class="max-w-xl mt-8">
        <h2 class="text-sm font-medium mb-3">Médias de ce souvenir</h2>
        <p class="text-xs text-stone-500 mb-3">Les photos et vidéos s'ajoutent depuis la page <a href="{{ route('admin.media.index') }}" class="text-amber-700 underline">Médias</a>, en sélectionnant ce souvenir.</p>
        <div class="grid grid-cols-3 gap-2">
            @foreach ($memory->media as $media)
                <div class="aspect-square bg-stone-100 rounded-md flex items-center justify-center text-xs text-stone-500">
                    {{ $media->type }}
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
