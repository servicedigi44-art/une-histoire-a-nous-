{{-- Timeline verticale par année, utilisée aux chapitres 01, 05 (et "premières années") --}}
<div class="relative border-l border-stone-800 ml-4 space-y-16 py-10">
    @foreach ($byYear as $year => $yearMemories)
        <div class="relative pl-8">
            <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-amber-700 border-4 border-black"></span>
            <h3 class="text-2xl text-amber-400 mb-4">{{ $year }}</h3>

            <div class="grid sm:grid-cols-2 gap-4">
                @foreach ($yearMemories as $memory)
                    @include('story.partials.memory-card', ['memory' => $memory])
                @endforeach
            </div>
        </div>
    @endforeach
</div>
