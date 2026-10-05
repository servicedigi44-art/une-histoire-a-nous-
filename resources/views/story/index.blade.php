@extends('layouts.app')

@section('title', 'Notre histoire')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-24">
    <h1 class="text-3xl md:text-4xl text-center mb-2 tracking-wide">Une histoire à nous</h1>
    <p class="text-center text-stone-400 mb-16">
        « Nous n'avons pas simplement grandi ensemble, nous avons été une vraie famille. »
    </p>

    <ol class="space-y-4">
        @foreach ($chapters as $chapter)
            <li>
                <a href="{{ route('story.chapter', $chapter) }}"
                   class="group flex items-center justify-between rounded-xl border border-stone-800 hover:border-amber-700 px-6 py-5 transition">
                    <span>
                        <span class="block text-xs uppercase tracking-widest text-amber-500">Chapitre {{ str_pad($chapter->number, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="block text-lg mt-1">{{ $chapter->title }}</span>
                    </span>
                    <span class="text-stone-600 group-hover:text-amber-500 transition">→</span>
                </a>
            </li>
        @endforeach
        <li>
            <a href="{{ route('story.friends') }}"
               class="group flex items-center justify-between rounded-xl border border-stone-800 hover:border-amber-700 px-6 py-5 transition">
                <span class="text-lg">Nos amis, un par un</span>
                <span class="text-stone-600 group-hover:text-amber-500 transition">→</span>
            </a>
        </li>
        <li>
            <a href="{{ route('story.capsule') }}"
               class="group flex items-center justify-between rounded-xl border border-stone-800 hover:border-amber-700 px-6 py-5 transition">
                <span class="text-lg">📦 Capsule 2036</span>
                <span class="text-stone-600 group-hover:text-amber-500 transition">→</span>
            </a>
        </li>
    </ol>
</section>
@endsection
