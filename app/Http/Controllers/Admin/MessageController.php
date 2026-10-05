<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PersonalMessageRequest;
use App\Models\Friend;
use App\Models\PersonalMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = PersonalMessage::with(['author', 'recipient'])->latest()->paginate(20);
        $friends = Friend::ordered()->get();

        return view('admin.messages.index', compact('messages', 'friends'));
    }

    public function store(PersonalMessageRequest $request): RedirectResponse
    {
        PersonalMessage::create($request->validated());

        return back()->with('status', 'Message créé.');
    }

    public function update(PersonalMessageRequest $request, PersonalMessage $message): RedirectResponse
    {
        $message->update($request->validated());

        return back()->with('status', 'Message mis à jour.');
    }

    public function destroy(PersonalMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('status', 'Message supprimé.');
    }

    public function toggle(PersonalMessage $message): RedirectResponse
    {
        $message->update(['is_visible' => !$message->is_visible]);

        return back()->with('status', 'Statut mis à jour.');
    }
}
