@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Souvenirs</h1>
    <a href="{{ route('admin.memories.create') }}" class="bg-amber-700 text-white text-sm rounded-md px-4 py-2 hover:bg-amber-600">+ Nouveau souvenir</a>
</div>

<div class="bg-white rounded-xl border border-stone-200 divide-y">
    @forelse ($memories as $memory)
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="font-medium">{{ $memory->title }} @if($memory->year) <span class="text-stone-400">· {{ $memory->year }}</span> @endif</p>
                <p class="text-xs text-stone-500">{{ $memory->chapter->title }} · type : {{ $memory->memory_type }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <form method="POST" action="{{ route('admin.memories.toggle', $memory) }}">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs {{ $memory->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $memory->is_active ? 'Actif' : 'Inactif' }}
                    </button>
                </form>
                <a href="{{ route('admin.memories.edit', $memory) }}" class="text-amber-700 hover:underline">Modifier</a>
                <form method="POST" action="{{ route('admin.memories.destroy', $memory) }}" onsubmit="return confirm('Supprimer ce souvenir et ses médias ?');">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <p class="px-5 py-6 text-sm text-stone-500">Aucun souvenir pour le moment.</p>
    @endforelse
</div>

<div class="mt-4">{{ $memories->links() }}</div>
@endsection
