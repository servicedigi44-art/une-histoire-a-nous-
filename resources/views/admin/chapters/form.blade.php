@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">{{ $chapter->exists ? 'Modifier le chapitre' : 'Nouveau chapitre' }}</h1>

<form method="POST"
      action="{{ $chapter->exists ? route('admin.chapters.update', $chapter) : route('admin.chapters.store') }}"
      enctype="multipart/form-data" class="bg-white rounded-xl border border-stone-200 p-6 space-y-4 max-w-xl">
    @csrf
    @if ($chapter->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm mb-1">Numéro</label>
        <input type="number" name="number" value="{{ old('number', $chapter->number) }}" class="w-full rounded-md border-stone-300 text-sm" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Titre</label>
        <input type="text" name="title" value="{{ old('title', $chapter->title) }}" class="w-full rounded-md border-stone-300 text-sm" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Slug (identifiant d'URL)</label>
        <input type="text" name="slug" value="{{ old('slug', $chapter->slug) }}" class="w-full rounded-md border-stone-300 text-sm" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Texte d'introduction</label>
        <textarea name="intro_text" rows="3" class="w-full rounded-md border-stone-300 text-sm">{{ old('intro_text', $chapter->intro_text) }}</textarea>
    </div>
    <div>
        <label class="block text-sm mb-1">Texte de conclusion</label>
        <textarea name="outro_text" rows="3" class="w-full rounded-md border-stone-300 text-sm">{{ old('outro_text', $chapter->outro_text) }}</textarea>
    </div>
    <div>
        <label class="block text-sm mb-1">Photo de couverture</label>
        <input type="file" name="cover_photo" class="w-full text-sm">
    </div>
    <div>
        <label class="block text-sm mb-1">Ordre d'affichage</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $chapter->sort_order) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chapter->is_active) ? 'checked' : '' }}>
        Chapitre actif (visible pour les visiteurs)
    </label>

    <div class="pt-2">
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Enregistrer</button>
        <a href="{{ route('admin.chapters.index') }}" class="ml-3 text-sm text-stone-500">Annuler</a>
    </div>
</form>
@endsection
