{{-- Slider "avant / maintenant" (chapitres 02 et 05) --}}
@foreach ($memories->where('memory_type', 'before_after') as $memory)
    @php
        $before = $memory->media->firstWhere('role', 'before');
        $after = $memory->media->firstWhere('role', 'after');
    @endphp
    <div class="before-after-slider relative max-w-xl mx-auto rounded-xl overflow-hidden border border-stone-800 mb-10"
         data-before-after>
        <div class="relative aspect-[4/5] bg-stone-900">
            @if ($after)
                <img src="{{ media_url($after) }}" class="absolute inset-0 w-full h-full object-cover" alt="Maintenant">
            @endif
            <div class="clip-wrapper absolute inset-0 overflow-hidden" style="width:50%">
                @if ($before)
                    <img src="{{ media_url($before) }}" class="w-full h-full object-cover" style="width:calc(100vw);max-width:36rem" alt="Avant">
                @endif
            </div>
            <input type="range" min="0" max="100" value="50" class="ba-range absolute bottom-3 left-3 right-3">
        </div>
        <p class="text-center text-xs text-stone-500 py-2">{{ $memory->title }}</p>
    </div>
@endforeach
