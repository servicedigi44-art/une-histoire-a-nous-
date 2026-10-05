{{-- "Dossiers" du chapitre 03 : regroupement par catégorie --}}
<div class="grid sm:grid-cols-2 gap-4">
    @forelse ($byCategory as $category => $categoryMemories)
        <details class="group rounded-xl border border-stone-800 overflow-hidden">
            <summary class="cursor-pointer px-5 py-4 flex items-center justify-between select-none">
                <span>📁 {{ $category }}</span>
                <span class="text-stone-500 text-xs">{{ $categoryMemories->count() }} souvenir(s)</span>
            </summary>
            <div class="px-5 pb-5 grid grid-cols-2 gap-3">
                @foreach ($categoryMemories as $memory)
                    @include('story.partials.memory-card', ['memory' => $memory])
                @endforeach
            </div>
        </details>
    @empty
        <p class="text-stone-500 text-sm">Aucun dossier pour le moment (à alimenter depuis l'administration).</p>
    @endforelse
</div>
