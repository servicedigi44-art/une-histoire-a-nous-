@extends('layouts.app')

@section('title', 'Nos amis')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-20">
    <h1 class="text-3xl text-center mb-16">Une famille choisie</h1>

    <div class="grid sm:grid-cols-2 gap-6">
        @foreach ($friends as $friend)
            <a href="{{ route('story.friend', $friend) }}"
               class="rounded-xl border border-stone-800 hover:border-amber-700 transition p-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-stone-900 shrink-0">
                    @if (friend_photo_url($friend, 'now'))
                        <img src="{{ friend_photo_url($friend, 'now') }}" class="w-full h-full object-cover" alt="{{ $friend->name }}">
                    @endif
                </div>
                <div>
                    <p class="font-medium">{{ $friend->name }}</p>
                    @if ($friend->nickname)
                        <p class="text-xs text-stone-500">« {{ $friend->nickname }} »</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <p class="text-center text-stone-500 italic mt-16 text-sm">
        Différents caractères. Différentes histoires. Différentes vies.<br>Mais une histoire à nous.
    </p>

    <div class="text-center mt-10">
        <a href="{{ route('story.index') }}" class="text-stone-500 hover:text-stone-300 text-sm">← Tous les chapitres</a>
    </div>
</section>
@endsection