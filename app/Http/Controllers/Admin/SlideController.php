<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlideController extends Controller
{
    public function __construct(private MediaStorageService $storage) {}

    public function index(): View
    {
        $slides = Slide::ordered()->get();

        return view('admin.slides.index', compact('slides'));
    }

    public function store(SlideRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $folder = $data['type'] === 'video' ? 'videos' : 'photos';
        $startOrder = $data['sort_order'] ?? ((int) Slide::max('sort_order') + 1);

        foreach ($request->file('files', []) as $i => $file) {
            $filePath = $this->storage->store($file, $folder);
            $thumbnailPath = null;

            if ($request->hasFile('thumbnail') && count($request->file('files')) === 1) {
                $thumbnailPath = $this->storage->store($request->file('thumbnail'), 'thumbnails');
            }

            Slide::create([
                'type' => $data['type'],
                'file_path' => $filePath,
                'thumbnail_path' => $thumbnailPath,
                'caption' => $data['caption'] ?? null,
                'slide_date' => $data['slide_date'] ?? null,
                'sort_order' => $startOrder + $i,
                'is_active' => true,
            ]);
        }

        $count = count($request->file('files', []));

        return back()->with('status', $count > 1 ? "$count elements ajoutes au diaporama." : 'Element ajoute au diaporama.');
    }

    public function update(SlideRequest $request, Slide $slide): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $slide->sort_order;
        $folder = $data['type'] === 'video' ? 'videos' : 'photos';

        if ($request->hasFile('files') && count($request->file('files')) > 0) {
            $data['file_path'] = $this->storage->replace($slide->file_path, $request->file('files')[0], $folder);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->storage->replace($slide->thumbnail_path, $request->file('thumbnail'), 'thumbnails');
        }

        unset($data['files'], $data['thumbnail']);

        $slide->update($data);

        return back()->with('status', 'Element mis a jour.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        $this->storage->delete($slide->file_path);
        $this->storage->delete($slide->thumbnail_path);
        $slide->delete();

        return back()->with('status', 'Element supprime.');
    }

    public function toggle(Slide $slide): RedirectResponse
    {
        $slide->update(['is_active' => !$slide->is_active]);

        return back()->with('status', 'Statut mis a jour.');
    }

    public function updateOrder(Request $request, Slide $slide): RedirectResponse
    {
        $request->validate(['sort_order' => ['required', 'integer', 'min:0']]);

        $slide->update(['sort_order' => $request->input('sort_order')]);

        return back()->with('status', 'Ordre mis a jour.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate(['order' => ['required', 'array']]);

        foreach ($request->input('order') as $position => $id) {
            Slide::where('id', $id)->update(['sort_order' => $position]);
        }

        return back()->with('status', 'Ordre mis a jour.');
    }
}