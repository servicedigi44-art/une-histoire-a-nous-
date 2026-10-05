@extends('layouts.app')

@section('title', $siteTitle)

@section('content')
<section class="h-screen w-full flex flex-col items-center justify-center bg-black text-center px-6">
    <h1 class="text-2xl md:text-3xl tracking-widest mb-4">UNE HISTOIRE À NOUS</h1>
    <p class="text-stone-400 italic">Chapitre suivant : à écrire ensemble…</p>

    <a href="{{ route('story.index') }}" class="mt-14 text-xs text-stone-600 hover:text-stone-400">
        ← Revivre notre histoire
    </a>
</section>
@endsection
