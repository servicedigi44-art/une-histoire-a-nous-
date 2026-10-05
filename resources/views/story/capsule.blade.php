@extends('layouts.app')

@section('title', 'Capsule 2036')

@section('content')
<section class="max-w-2xl mx-auto px-6 py-20 text-center">
    <p class="text-amber-500 text-xs uppercase tracking-widest mb-2">Prochain rendez-vous : {{ $nextRendezVous }}</p>
    <h1 class="text-3xl mb-4">📦 Capsule {{ $nextRendezVous }}</h1>
    <p class="text-stone-400 mb-16">
        « Nous avons laissé quelque chose pour nous-mêmes. Rendez-vous dans 10 ans. »
    </p>

    <div class="space-y-4 text-left">
        @forelse ($capsules as $capsule)
            <div class="rounded-xl border border-stone-800 p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-medium">{{ $capsule->friend->name }}</p>
                    @if ($capsule->isOpen())
                        <span class="text-xs text-emerald-400">🔓 Ouverte</span>
                    @else
                        <span class="text-xs text-stone-500">🔒 Verrouillée</span>
                    @endif
                </div>

                @if ($capsule->isOpen())
                    <p class="text-stone-300 text-sm leading-relaxed">{{ $capsule->content }}</p>
                @else
                    <p class="text-stone-600 text-sm italic">
                        Cette capsule est verrouillée jusqu'au {{ $capsule->unlock_at->translatedFormat('d F Y') }}.
                    </p>
                @endif
            </div>
        @empty
            <p class="text-stone-600 text-sm text-center">Aucune capsule enregistrée pour le moment.</p>
        @endforelse
    </div>

    <div class="mt-10">
        <a href="{{ route('story.index') }}" class="text-stone-500 hover:text-stone-300 text-sm">← Tous les chapitres</a>
    </div>
</section>
@endsection