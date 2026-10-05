@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Messages personnels</h1>

<div class="bg-white rounded-xl border border-stone-200 p-6 mb-8 max-w-xl">
    <h2 class="text-sm font-medium mb-4">Ajouter un message ("Un mot pour toi")</h2>
    <form method="POST" action="{{ route('admin.messages.store') }}" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm mb-1">De la part de</label>
            <select name="author_friend_id" class="w-full rounded-md border-stone-300 text-sm" required>
                @foreach ($friends as $friend)
                    <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Pour</label>
            <select name="recipient_friend_id" class="w-full rounded-md border-stone-300 text-sm" required>
                @foreach ($friends as $friend)
                    <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Message</label>
            <textarea name="content" rows="3" class="w-full rounded-md border-stone-300 text-sm" required></textarea>
        </div>
        <button class="bg-amber-700 text-white text-sm rounded-md px-5 py-2 hover:bg-amber-600">Ajouter</button>
    </form>
</div>

<div class="bg-white rounded-xl border border-stone-200 divide-y">
    @foreach ($messages as $message)
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="text-sm">{{ $message->author->name }} → {{ $message->recipient->name }}</p>
                <p class="text-xs text-stone-500 truncate max-w-md">{{ $message->content }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs {{ $message->is_visible ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-100 text-stone-500' }}">
                        {{ $message->is_visible ? 'Visible' : 'Masqué' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Supprimer ce message ?');">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-4">{{ $messages->links() }}</div>
@endsection
