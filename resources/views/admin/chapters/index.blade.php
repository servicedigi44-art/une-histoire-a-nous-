@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Chapitres</h1>
    <a href="{{ route('admin.chapters.create') }}" class="bg-amber-700 text-white text-sm rounded-md px-4 py-2 hover:bg-amber-600">+ Nouveau chapitre</a>
</div>

<div class="bg-white rounded-xl border border-stone-200 divide-y">
    @foreach ($chapters as $chapter)
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="font-medium">#{{ $chapter->number }} — {{ $chapter->title }}</p>
                <p class="text-xs text-stone-500">{{ $chapter->memories_count }} souvenir(s) · slug : {{ $chapter->slug }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <form method="POST" action="{{ route('admin.chapters.toggle', $chapter) }}">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs {{ $chapter->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $chapter->is_active ? 'Actif' : 'Inactif' }}
                    </button>
                </form>
                <a href="{{ route('admin.chapters.edit', $chapter) }}" class="text-amber-700 hover:underline">Modifier</a>
                <form method="POST" action="{{ route('admin.chapters.destroy', $chapter) }}"
                      onsubmit="return confirm('Supprimer ce chapitre et tous ses souvenirs ?');">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
