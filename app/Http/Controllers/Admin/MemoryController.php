<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemoryRequest;
use App\Models\Chapter;
use App\Models\Memory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemoryController extends Controller
{
    public function index(): View
    {
        $memories = Memory::with('chapter')->ordered()->paginate(20);

        return view('admin.memories.index', compact('memories'));
    }

    public function create(): View
    {
        $chapters = Chapter::ordered()->get();

        return view('admin.memories.form', ['memory' => new Memory(), 'chapters' => $chapters]);
    }

    public function store(MemoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Memory::create($data);

        return redirect()->route('admin.memories.index')->with('status', 'Souvenir cree.');
    }

    public function edit(Memory $memory): View
    {
        $chapters = Chapter::ordered()->get();
        $memory->load('media');

        return view('admin.memories.form', compact('memory', 'chapters'));
    }

    public function update(MemoryRequest $request, Memory $memory): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $memory->update($data);

        return redirect()->route('admin.memories.index')->with('status', 'Souvenir mis a jour.');
    }

    public function destroy(Memory $memory): RedirectResponse
    {
        $storage = app(\App\Services\MediaStorageService::class);
        foreach ($memory->media as $media) {
            $storage->delete($media->file_path);
            $storage->delete($media->thumbnail_path);
        }

        $memory->delete();

        return redirect()->route('admin.memories.index')->with('status', 'Souvenir supprime.');
    }

    public function toggle(Memory $memory): RedirectResponse
    {
        $memory->update(['is_active' => !$memory->is_active]);

        return back()->with('status', 'Statut mis a jour.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate(['order' => ['required', 'array']]);

        foreach ($request->input('order') as $position => $id) {
            Memory::where('id', $id)->update(['sort_order' => $position]);
        }

        return back()->with('status', 'Ordre mis a jour.');
    }
}