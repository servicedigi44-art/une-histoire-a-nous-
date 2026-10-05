<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FriendRequest;
use App\Models\Friend;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FriendController extends Controller
{
    public function __construct(private MediaStorageService $storage) {}

    public function index(): View
    {
        $friends = Friend::ordered()->get();

        return view('admin.friends.index', compact('friends'));
    }

    public function create(): View
    {
        return view('admin.friends.form', ['friend' => new Friend()]);
    }

    public function store(FriendRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data = $this->handlePhotos($request, $data);

        Friend::create($data);

        return redirect()->route('admin.friends.index')->with('status', 'Ami cree.');
    }

    public function edit(Friend $friend): View
    {
        return view('admin.friends.form', compact('friend'));
    }

    public function update(FriendRequest $request, Friend $friend): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data = $this->handlePhotos($request, $data, $friend);

        $friend->update($data);

        return redirect()->route('admin.friends.index')->with('status', 'Ami mis a jour.');
    }

    public function destroy(Friend $friend): RedirectResponse
    {
        $this->storage->delete($friend->photo_child_path);
        $this->storage->delete($friend->photo_teen_path);
        $this->storage->delete($friend->photo_now_path);
        $friend->delete();

        return redirect()->route('admin.friends.index')->with('status', 'Ami supprime.');
    }

    public function toggle(Friend $friend): RedirectResponse
    {
        $friend->update(['is_active' => !$friend->is_active]);

        return back()->with('status', 'Statut mis a jour.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate(['order' => ['required', 'array']]);

        foreach ($request->input('order') as $position => $id) {
            Friend::where('id', $id)->update(['sort_order' => $position]);
        }

        return back()->with('status', 'Ordre mis a jour.');
    }

    private function handlePhotos(Request $request, array $data, ?Friend $friend = null): array
    {
        $map = [
            'photo_child' => 'photo_child_path',
            'photo_teen' => 'photo_teen_path',
            'photo_now' => 'photo_now_path',
        ];

        foreach ($map as $input => $column) {
            if ($request->hasFile($input)) {
                $old = $friend?->{$column};
                $data[$column] = $old
                    ? $this->storage->replace($old, $request->file($input), 'friends')
                    : $this->storage->store($request->file($input), 'friends');
            }
            unset($data[$input]);
        }

        return $data;
    }
}