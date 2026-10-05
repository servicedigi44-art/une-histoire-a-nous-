<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChapterRequest;
use App\Models\Chapter;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChapterController extends Controller
{
    public function __construct(private MediaStorageService $storage) {}

    public function index(): View
    {
        $chapters = Chapter::ordered()->withCount('memories')->get();

        return view('admin.chapters.index', compact('chapters'));
    }

    public function create(): View
    {
        return view('admin.chapters.form', ['chapter' => new Chapter()]);
    }

    public function store(ChapterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('cover_photo')) {
            $data['cover_photo_path'] = $this->storage->store($request->file('cover_photo'), 'chapters');
        }

        Chapter::create($data);

        return redirect()->route('admin.chapters.index')->with('status', 'Chapitre cree.');
    }

    public function edit(Chapter $chapter): View
    {
        return view('admin.chapters.form', compact('chapter'));
    }

    public function update(ChapterRequest $request, Chapter $chapter): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('cover_photo')) {
            $data['cover_photo_path'] = $this->storage->replace(
                $chapter->cover_photo_path,
                $request->file('cover_photo'),
                'chapters'
            );
        }

        $chapter->update($data);

        return redirect()->route('admin.chapters.index')->with('status', 'Chapitre mis a jour.');
    }

    public function destroy(Chapter $chapter): RedirectResponse
    {
        $this->storage->delete($chapter->cover_photo_path);
        $chapter->delete();

        return redirect()->route('admin.chapters.index')->with('status', 'Chapitre supprime.');
    }

    public function toggle(Chapter $chapter): RedirectResponse
    {
        $chapter->update(['is_active' => !$chapter->is_active]);

        return back()->with('status', 'Statut mis a jour.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate(['order' => ['required', 'array']]);

        foreach ($request->input('order') as $position => $id) {
            Chapter::where('id', $id)->update(['sort_order' => $position]);
        }

        return back()->with('status', 'Ordre mis a jour.');
    }
}