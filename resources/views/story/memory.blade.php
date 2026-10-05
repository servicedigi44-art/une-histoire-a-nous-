@extends('layouts.app')

@section('title', $memory->title)

@section('content')
<section class="max-w-2xl mx-auto px-6 py-20">
    <a href="{{ route('story.chapter', $memory->chapter) }}" class="text-stone-500 hover:text-stone-300 text-sm">
        ← {{ $memory->chapter->title }}
    </a>

    <h1 class="text-2xl md:text-3xl mt-6 mb-1">{{ $memory->title }}</h1>
    @if ($memory->year)
        <p class="text-amber-500 text-sm mb-8">{{ $memory->year }}</p>
    @endif

    @if ($memory->media->isNotEmpty())
        <div class="grid gap-4 mb-10 {{ $memory->media->count() > 1 ? 'sm:grid-cols-2' : '' }}">
            @foreach ($memory->media as $media)
                <div class="rounded-xl overflow-hidden border border-stone-800 bg-stone-950">
                    @if ($media->isVideo())
                        <video controls preload="none" poster="{{ media_url($media, 'thumbnail') }}" class="w-full">
                            <source src="{{ media_url($media) }}">
                        </video>
                    @else
                        <img src="{{ media_url($media) }}" alt="{{ $media->caption }}" class="w-full" loading="lazy">
                    @endif
                    @if ($media->caption)
                        <p class="text-xs text-stone-500 px-3 py-2">{{ $media->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="rounded-xl border border-dashed border-stone-800 p-10 text-center text-stone-600 text-sm mb-10">
            Aucun média ajouté pour ce souvenir pour le moment.
        </div>
    @endif

    @if ($memory->description)
        <p class="text-stone-300 leading-relaxed mb-6">{{ $memory->description }}</p>
    @endif

    @if ($memory->anecdote)
        <div class="rounded-lg bg-stone-900/60 border border-stone-800 p-5">
            <p class="text-xs uppercase tracking-widest text-amber-500 mb-2">Vous souvenez-vous de ce jour ?</p>
            <p class="text-stone-300 text-sm leading-relaxed">{{ $memory->anecdote }}</p>
        </div>
    @endif
</section>
@endsection
