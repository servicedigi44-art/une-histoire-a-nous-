<a href="{{ route('story.memory', $memory) }}"
   class="block rounded-lg overflow-hidden border border-stone-800 hover:border-amber-700 transition bg-stone-950">
    @php $cover = $memory->media->first(); @endphp
    <div class="aspect-video bg-stone-900 flex items-center justify-center text-stone-600 text-sm">
        @if ($cover && media_url($cover, 'thumbnail'))
            <img src="{{ media_url($cover, 'thumbnail') }}"
                 alt="{{ $cover->caption }}" class="w-full h-full object-cover" loading="lazy">
        @elseif ($cover)
            <img src="{{ media_url($cover) }}" alt="{{ $cover->caption }}" class="w-full h-full object-cover" loading="lazy">
        @else
            Souvenir sans média (démo)
        @endif
    </div>
    <div class="p-4">
        <p class="text-sm font-medium">{{ $memory->title }}</p>
        @if ($memory->description)
            <p class="text-xs text-stone-500 mt-1 line-clamp-2">{{ $memory->description }}</p>
        @endif
    </div>
</a>
