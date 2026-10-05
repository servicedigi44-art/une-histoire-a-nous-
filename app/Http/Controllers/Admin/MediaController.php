<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaUploadRequest;
use App\Models\Friend;
use App\Models\Media;
use App\Models\Memory;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(private MediaStorageService $storage) {}

    public function index(): View
    {
        $media = Media::with(['memory', 'friend'])->latest()->paginate(24);
        $memories = Memory::ordered()->get();
        $friends = Friend::ordered()->get();

        return view('admin.media.index', compact('media', 'memories', 'friends'));
    }

    public function store(MediaUploadRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $folder = $data['type'] === 'video' ? 'videos' : 'photos';

        $data['file_path'] = $this->storage->store($request->file('file'), $folder);
        $data['size_bytes'] = $request->file('file')->getSize();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->storage->store($request->file('thumbnail'), 'thumbnails');
        }

        unset($data['file'], $data['thumbnail']);

        Media::create($data);

        return back()->with('status', 'Média ajouté.');
    }

    public function update(MediaUploadRequest $request, Media $media): RedirectResponse
    {
        $data = $request->validated();
        $folder = $data['type'] === 'video' ? 'videos' : 'photos';

        if ($request->hasFile('file')) {
            $data['file_path'] = $this->storage->replace($media->file_path, $request->file('file'), $folder);
            $data['size_bytes'] = $request->file('file')->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->storage->replace($media->thumbnail_path, $request->file('thumbnail'), 'thumbnails');
        }

        unset($data['file'], $data['thumbnail']);

        $media->update($data);

        return back()->with('status', 'Média mis à jour.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->storage->delete($media->file_path);
        $this->storage->delete($media->thumbnail_path);
        $media->delete();

        return back()->with('status', 'Média supprimé.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate(['order' => ['required', 'array']]);

        foreach ($request->input('order') as $position => $id) {
            Media::where('id', $id)->update(['sort_order' => $position]);
        }

        return back()->with('status', 'Ordre mis à jour.');
    }
}
