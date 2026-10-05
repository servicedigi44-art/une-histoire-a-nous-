@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Amis</h1>
    <a href="{{ route('admin.friends.create') }}" class="bg-amber-700 text-white text-sm rounded-md px-4 py-2 hover:bg-amber-600">+ Nouvel ami</a>
</div>

<div class="bg-white rounded-xl border border-stone-200 divide-y">
    @foreach ($friends as $friend)
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="font-medium">{{ $friend->name }} @if($friend->nickname)<span class="text-stone-400">· {{ $friend->nickname }}</span>@endif</p>
                <p class="text-xs text-stone-500">{{ $friend->photosCount() }} photo(s) · {{ $friend->videosCount() }} vidéo(s)</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <form method="POST" action="{{ route('admin.friends.toggle', $friend) }}">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs {{ $friend->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $friend->is_active ? 'Actif' : 'Inactif' }}
                    </button>
                </form>
                <a href="{{ route('admin.friends.edit', $friend) }}" class="text-amber-700 hover:underline">Modifier</a>
                <form method="POST" action="{{ route('admin.friends.destroy', $friend) }}" onsubmit="return confirm('Supprimer cet ami ?');">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
