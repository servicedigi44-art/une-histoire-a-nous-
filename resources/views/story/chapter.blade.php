@extends('layouts.app')

@section('title', $chapter->title)

@section('content')
<section class="max-w-3xl mx-auto px-6 py-20">
    <p class="text-amber-500 text-xs uppercase tracking-widest text-center mb-2">
        Chapitre {{ str_pad($chapter->number, 2, '0', STR_PAD_LEFT) }}
    </p>
    <h1 class="text-3xl md:text-4xl text-center mb-8">{{ $chapter->title }}</h1>

    @if ($chapter->intro_text)
        <p class="text-stone-300 text-center leading-relaxed max-w-xl mx-auto mb-16">
            {{ $chapter->intro_text }}
        </p>
    @endif

    {{-- Chaque chapitre réutilise les blocs narratifs qui lui correspondent --}}
    @switch($chapter->slug)
        @case('nos-delires')
            @include('story.partials.dossiers')
            @break

        @case('grandir-ensemble')
            @include('story.partials.before-after')
            @if ($byYear->isNotEmpty())
                @include('story.partials.timeline')
            @endif
            @break

        @case('les-annees-passent')
            @include('story.partials.timeline')
            @include('story.partials.before-after')
            <div class="text-center mt-16">
                <a href="{{ route('story.capsule') }}" class="inline-block border border-amber-700 text-amber-200 hover:bg-amber-700 hover:text-white transition rounded-full px-8 py-3 text-sm">
                    📦 Découvrir la capsule 2036 →
                </a>
            </div>
            @break

        @case('bons-et-mauvais-moments')
            @include('story.partials.portraits')
            @if ($memories->isNotEmpty())
                <div class="grid sm:grid-cols-2 gap-4 mt-12">
                    @foreach ($memories as $memory)
                        @include('story.partials.memory-card', ['memory' => $memory])
                    @endforeach
                </div>
            @endif
            @break

        @case('une-famille-choisie')
            <div class="text-center">
                <a href="{{ route('story.friends') }}" class="inline-block border border-amber-700 text-amber-200 hover:bg-amber-700 hover:text-white transition rounded-full px-8 py-3 text-sm">
                    Découvrir chacun d'entre nous →
                </a>
            </div>
            @break

        @case('la-suite-de-notre-histoire')
            @if ($memories->isNotEmpty())
                <div class="grid sm:grid-cols-2 gap-4 mb-12">
                    @foreach ($memories as $memory)
                        @include('story.partials.memory-card', ['memory' => $memory])
                    @endforeach
                </div>
            @endif
            <div class="text-center mt-16 space-y-6">
                <p class="text-stone-400 italic">« Certaines familles naissent des liens du sang, mais la nôtre est née de l'amour que nous partageons à travers cette amitié pure et véritable. »</p>
                <p class="text-lg">« Alors… on continue ? »</p>
                <a href="{{ route('story.final') }}" class="inline-block border border-amber-700 text-amber-200 hover:bg-amber-700 hover:text-white transition rounded-full px-8 py-3 text-sm">
                    Continuer notre histoire →
                </a>
            </div>
            @break

        @default
            @if ($byYear->isNotEmpty())
                @include('story.partials.timeline')
            @elseif ($memories->isNotEmpty())
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ($memories as $memory)
                        @include('story.partials.memory-card', ['memory' => $memory])
                    @endforeach
                </div>
            @else
                <p class="text-center text-stone-600 text-sm">Aucun souvenir n'a encore été ajouté à ce chapitre.</p>
            @endif
    @endswitch

    @if ($chapter->outro_text)
        <p class="text-stone-400 text-center italic leading-relaxed max-w-xl mx-auto mt-20">
            {{ $chapter->outro_text }}
        </p>
    @endif

    <div class="flex justify-between items-center mt-16 text-sm">
        <a href="{{ route('story.index') }}" class="text-stone-500 hover:text-stone-300">← Tous les chapitres</a>
        @if ($nextChapter)
            <a href="{{ route('story.chapter', $nextChapter) }}" class="text-amber-500 hover:text-amber-400">
                Chapitre suivant →
            </a>
        @endif
    </div>
</section>
@endsection
