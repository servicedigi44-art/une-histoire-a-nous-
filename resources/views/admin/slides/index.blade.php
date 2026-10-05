@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Diaporama</h1>

<div class="bg-white rounded-xl border border-stone-200 p-6 mb-8 max-w-xl">
    <h2 class="text-sm font-medium mb-3">Musique de fond</h2>
    @php($musicPath = \App\Models\Setting::get('background_music_path'))
    @if ($musicPath)
        <p class="text-xs text-emerald-700 mb-2">Une musique est deja en place.</p>
        <audio controls class="w-full mb-3">
            <source src="{{ music_url() }}">
        </audio>
        <form method="POST" action="{{ route('admin.music.destroy') }}" onsubmit="return confirm('Retirer la musique ?');">
            @csrf @method('DELETE')
            <button class="text-xs text-red-600 hover:underline">Retirer la musique</button>
        </form>
    @else
        <p class="text-xs text-stone-500 mb-3">Aucune musique pour le moment.</p>
    @endif
    <form method="POST" action="{{ route('admin.music.store') }}" enctype="multipart/form-data" class="flex items-center gap-2 mt-3">
        @csrf
        <input type="file" name="music" accept=".mp3,.wav,.ogg,.m4a" class="text-sm">
        <button class="bg-amber-700 text-white text-sm rounded-md px-4 py-2 hover:bg-amber-600">Enregistrer</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-stone-200 p-6 mb-8 max-w-xl">
    <h2 class="text-sm font-medium mb-1">Ajouter des photos ou videos</h2>
    <p class="text-xs text-stone-500 mb-4">Tu peux en selectionner plusieurs a la fois (meme type). La legende et la date s'appliqueront a toutes.</p>
    <form method="POST" action="{{ route('admin.slides.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm mb-1">Type</label>
            <select name="type" class="w-full rounded-md border-stone-300 text-sm" required>
                <option value="image">Photo(s)</option>
                <option value="video">Video(s)</option>
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Fichiers (selection multiple possible)</label>
            <input type="file" name="files[]" multiple class="w-full text-sm" required>
        </div>
        <div>
            <label class="block text-sm mb-1">Miniature (uniquement si un seul fichier video)</label>
            <input type="file" name="thumbnail" class="w-full text-sm">
        </div>
        <div>
            <label class="block text-sm mb-1">Legende (facultatif, appliquee a tous les fichiers)</label>
            <input type="text" name="caption" class="w-full rounded-md border-stone-300 text-sm">
        </div>
        <div>
            <label class="block text-sm mb-1">Date / annee (facultatif)</label>
            <input type="text" name="slide_date" class="w-full rounded-md border-stone-300 text-sm" placeholder="ex: 2014">
        </div>
        <div>
            <label class="block text-sm mb-1">Ordre d'affichage de depart (facultatif)</label>
            <input type="number" name="sort_order" class="w-full rounded-md border-stone-300 text-sm">
        </div>
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Ajouter au diaporama</button>
    </form>
</div>

<p class="text-xs text-stone-500 mb-3">Les elements defilent du plus petit numero d'ordre au plus grand. Change un numero puis clique sur la coche pour sauvegarder.</p>

<div class="grid sm:grid-cols-4 gap-4">
    @foreach ($slides as $slide)
        <div class="bg-white rounded-xl border border-stone-200 p-3">
            <div class="aspect-square bg-stone-100 rounded-md overflow-hidden mb-2 flex items-center justify-center">
                @if ($slide->type === 'video')
                    <video src="{{ media_url_for_slide($slide) }}" class="w-full h-full object-cover" muted></video>
                @else
                    <img src="{{ media_url_for_slide($slide) }}" class="w-full h-full object-cover" alt="{{ $slide->caption }}">
                @endif
            </div>
            <p class="text-xs text-stone-600 truncate">{{ $slide->caption ?: '(sans legende)' }} @if($slide->slide_date) · {{ $slide->slide_date }} @endif</p>

            <form method="POST" action="{{ route('admin.slides.order', $slide) }}" class="flex items-center gap-1 mt-2">
                @csrf @method('PATCH')
                <label class="text-xs text-stone-500">Ordre</label>
                <input type="number" name="sort_order" value="{{ $slide->sort_order }}" class="w-16 rounded-md border-stone-300 text-xs py-1">
                <button class="text-xs text-emerald-700 hover:underline">✓</button>
            </form>

            <div class="flex items-center justify-between mt-2">
                <form method="POST" action="{{ route('admin.slides.toggle', $slide) }}">
                    @csrf @method('PATCH')
                    <button class="px-2 py-1 rounded-full text-xs {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $slide->is_active ? 'Actif' : 'Inactif' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.slides.destroy', $slide) }}" onsubmit="return confirm('Supprimer cet element ?');">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection