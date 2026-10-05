@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Tableau de bord</h1>

<div class="grid sm:grid-cols-3 gap-4">
    @foreach ([
        'Chapitres actifs' => $stats['chapters_active'].' / '.$stats['chapters'],
        'Souvenirs' => $stats['memories'],
        'Médias' => $stats['media'],
        'Amis' => $stats['friends'],
        'Messages' => $stats['messages'],
        'Capsules verrouillées' => $stats['capsules_locked'].' / '.$stats['capsules'],
    ] as $label => $value)
        <div class="bg-white rounded-xl border border-stone-200 p-5">
            <p class="text-sm text-stone-500">{{ $label }}</p>
            <p class="text-2xl font-semibold mt-1">{{ $value }}</p>
        </div>
    @endforeach
</div>
