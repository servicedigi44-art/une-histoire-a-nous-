@extends('layouts.app')

@section('title', $siteTitle)

@section('content')
<section class="fixed inset-0 bg-black overflow-hidden" id="story-player">
    @if (music_url())
        <audio id="story-music" loop>
            <source src="{{ music_url() }}">
        </audio>
        <button id="story-enable-sound" class="fixed top-4 right-4 z-50 bg-white/90 text-black text-xs rounded-full px-4 py-2" style="display:none">
            🔊 Activer le son
        </button>
    @endif

    @forelse ($items as $i => $item)
        <div class="story-slide absolute inset-0 flex flex-col items-center justify-center text-center px-6 {{ $i === 0 ? 'is-active' : '' }}"
             data-slide>

            @if ($item['kind'] === 'slide')
                @if ($item['type'] === 'video')
                    <video src="{{ $item['url'] }}" class="max-h-[80vh] max-w-full rounded-lg" autoplay muted playsinline></video>
                @else
                    <img src="{{ $item['url'] }}" class="max-h-[80vh] max-w-full rounded-lg object-contain" alt="{{ $item['caption'] }}">
                @endif
                @if ($item['date'])
                    <p class="text-amber-500 text-sm mt-4">{{ $item['date'] }}</p>
                @endif
                @if ($item['caption'])
                    <p class="text-stone-300 text-base mt-2 max-w-lg">{{ $item['caption'] }}</p>
                @endif

            @elseif ($item['kind'] === 'friend')
                @if ($item['photo'])
                    <div class="w-32 h-32 rounded-full overflow-hidden border border-stone-700 mb-5">
                        <img src="{{ $item['photo'] }}" class="w-full h-full object-cover" alt="{{ $item['name'] }}">
                    </div>
                @endif
                <h2 class="text-2xl text-stone-100">{{ $item['name'] }}</h2>
                @if ($item['nickname'])
                    <p class="text-amber-500 text-sm mt-1">« {{ $item['nickname'] }} »</p>
                @endif
                @if ($item['bio'])
                    <p class="text-stone-400 text-sm mt-4 max-w-md">{{ $item['bio'] }}</p>
                @endif

            @elseif ($item['kind'] === 'message')
                <p class="text-xs uppercase tracking-widest text-amber-500 mb-4">Un mot pour toi</p>
                <p class="text-stone-200 text-lg max-w-md leading-relaxed">« {{ $item['content'] }} »</p>
                <p class="text-stone-500 text-sm mt-4">{{ $item['author'] }} → {{ $item['recipient'] }}</p>
            @endif
        </div>
    @empty
        <div class="story-slide absolute inset-0 flex items-center justify-center is-active">
            <p class="text-stone-600 text-sm">Rien a afficher pour le moment. Ajoute du contenu depuis l'administration.</p>
        </div>
    @endforelse

    <div class="story-slide absolute inset-0 flex flex-col items-center justify-center text-center px-6" data-slide data-final="1">
        <h1 class="text-2xl md:text-3xl tracking-widest mb-4">UNE HISTOIRE A NOUS</h1>
        <p class="text-stone-400 italic">Chapitre suivant : a ecrire ensemble…</p>
        <a href="{{ route('story.play') }}" class="mt-10 text-xs text-stone-600 hover:text-stone-400">↻ Revivre notre histoire</a>
    </div>

    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-6 text-white">
        <button id="story-prev" class="text-2xl opacity-70 hover:opacity-100">‹</button>
        <button id="story-pause" class="text-2xl opacity-70 hover:opacity-100">⏸</button>
        <button id="story-next" class="text-2xl opacity-70 hover:opacity-100">›</button>
    </div>
</section>
@endsection