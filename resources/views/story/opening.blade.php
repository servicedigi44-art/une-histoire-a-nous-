@extends('layouts.app')

@section('title', $siteTitle)

@section('content')
<section id="opening" class="h-screen w-full flex flex-col items-center justify-center bg-black text-center px-6"
         x-data="{ step: 0 }" x-init="setTimeout(() => step = 1, 1000); setTimeout(() => step = 2, 3200)">

    <p class="opening-line text-stone-300 text-lg md:text-xl tracking-wide transition-opacity duration-1000"
       x-show="step >= 1" x-transition.opacity.duration.1000ms>
        Avant de commencer…
    </p>

    <p class="opening-line text-stone-300 text-lg md:text-xl tracking-wide mt-3 transition-opacity duration-1000"
       x-show="step >= 2" x-transition.opacity.duration.1000ms>
        Prenez quelques minutes.
    </p>

    <a href="{{ route('story.play') }}"
       x-show="step >= 2" x-transition.opacity.duration.1000ms
       class="mt-14 inline-block border border-amber-700 text-amber-200 hover:bg-amber-700 hover:text-white transition rounded-full px-8 py-3 text-sm tracking-wide">
        Commencer notre histoire →
    </a>
</section>
@endsection