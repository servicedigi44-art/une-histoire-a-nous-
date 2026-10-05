@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">{{ $friend->exists ? 'Modifier l\'ami' : 'Nouvel ami' }}</h1>

<form method="POST"
      action="{{ $friend->exists ? route('admin.friends.update', $friend) : route('admin.friends.store') }}"
      enctype="multipart/form-data" class="bg-white rounded-xl border border-stone-200 p-6 space-y-4 max-w-xl">
    @csrf
    @if ($friend->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm mb-1">Prénom / Nom</label>
        <input type="text" name="name" value="{{ old('name', $friend->name) }}" class="w-full rounded-md border-stone-300 text-sm" required>
    </div>
    <div>
        <label class="block text-sm mb-1">Surnom</label>
        <input type="text" name="nickname" value="{{ old('nickname', $friend->nickname) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <div>
        <label class="block text-sm mb-1">Bio</label>
        <textarea name="bio" rows="3" class="w-full rounded-md border-stone-300 text-sm">{{ old('bio', $friend->bio) }}</textarea>
    </div>
    <div>
        <label class="block text-sm mb-1">Année de naissance</label>
        <input type="number" name="birth_year" value="{{ old('birth_year', $friend->birth_year) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <div class="grid grid-cols-3 gap-3">
        <div>
            <label class="block text-sm mb-1">Photo enfant</label>
            <input type="file" name="photo_child" class="w-full text-xs">
        </div>
        <div>
            <label class="block text-sm mb-1">Photo ado</label>
            <input type="file" name="photo_teen" class="w-full text-xs">
        </div>
        <div>
            <label class="block text-sm mb-1">Photo actuelle</label>
            <input type="file" name="photo_now" class="w-full text-xs">
        </div>
    </div>
    <div>
        <label class="block text-sm mb-1">Ordre d'affichage</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $friend->sort_order) }}" class="w-full rounded-md border-stone-300 text-sm">
    </div>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $friend->is_active) ? 'checked' : '' }}>
        Profil actif
    </label>

    <div class="pt-2">
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Enregistrer</button>
        <a href="{{ route('admin.friends.index') }}" class="ml-3 text-sm text-stone-500">Annuler</a>
    </div>
</form>
@endsection
