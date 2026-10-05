{{-- Portraits utilisés au chapitre 04 --}}
<div class="grid sm:grid-cols-3 gap-5">
    @foreach ($friends ?? [] as $friend)
        <a href="{{ route('story.friend', $friend) }}" class="text-center group">
            <div class="aspect-square rounded-full overflow-hidden bg-stone-900 mx-auto w-28 border border-stone-800 group-hover:border-amber-700 transition">
                @if (friend_photo_url($friend, 'now'))
                    <img src="{{ friend_photo_url($friend, 'now') }}" class="w-full h-full object-cover" alt="{{ $friend->name }}">
                @endif
            </div>
            <p class="mt-2 text-sm">{{ $friend->name }}</p>
        </a>
    @endforeach
</div>
