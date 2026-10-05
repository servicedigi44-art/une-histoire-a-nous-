@extends('layouts.app')

@section('title', $friend->name)

@section('content')
<section class="max-w-2xl mx-auto px-6 py-20">
    <a href="{{ route('story.friends') }}" class="text-stone-500 hover:text-stone-300 text-sm">← Nos amis</a>

    <div class="text-center mt-8 mb-10">
        <div class="w-28 h-28 rounded-full overflow-hidden bg-stone-900 mx-auto border border-stone-800">
            @if (friend_photo_url($friend, 'now'))
                <img src="{{ friend_photo_url($friend, 'now') }}" class="w-full h-full object-cover" alt="{{ $friend->name }}">
            @endif
        </div>
        <h1 class="text-2xl mt-4">{{ $friend->name }}</h1>
        @if ($friend->nickname)
            <p class="text-amber-500 text-sm">« {{ $friend->nickname }} »</p>
        @endif
    </div>

    @if ($friend->bio)
        <p class="text-stone-300 text-center leading-relaxed max-w-md mx-auto mb-10">{{ $friend->bio }}</p>
    @endif

    {{-- Évolution enfant / ado / actuel --}}
    <div class="grid grid-cols-3 gap-3 mb-12">
        @foreach (['child' => 'Enfant', 'teen' => 'Ado', 'now' => 'Aujourd\'hui'] as $stage => $label)
            <div class="text-center">
                <div class="aspect-square rounded-lg overflow-hidden bg-stone-900 border border-stone-800">
                    @if (friend_photo_url($friend, $stage))
                        <img src="{{ friend_photo_url($friend, $stage) }}" class="w-full h-full object-cover" alt="{{ $label }}">
                    @endif
                </div>
                <p class="text-xs text-stone-500 mt-1">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    {{-- Statistiques, affichées seulement quand les données existent --}}
    <div class="grid grid-cols-3 gap-3 text-center mb-12 text-sm">
        @if ($friend->friendshipYears() !== null)
            <div><span class="block text-xl text-amber-500">{{ $friend->friendshipYears() }}</span>ans d'amitié</div>
        @endif
        <div><span class="block text-xl text-amber-500">{{ $friend->photosCount() }}</span>photos</div>
        <div><span class="block text-xl text-amber-500">{{ $friend->videosCount() }}</span>vidéos</div>
    </div>

    {{-- Messages des autres amis --}}
    @if ($friend->receivedMessages->isNotEmpty())
        <h2 class="text-sm uppercase tracking-widest text-stone-500 mb-4">Un mot pour toi</h2>
        <div class="space-y-4">
            @foreach ($friend->receivedMessages as $message)
                <div class="rounded-lg bg-stone-900/60 border border-stone-800 p-4">
                    <p class="text-stone-300 text-sm leading-relaxed">« {{ $message->content }} »</p>
                    <p class="text-xs text-amber-500 mt-2">— {{ $message->author->name }}</p>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
