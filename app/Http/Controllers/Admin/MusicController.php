<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\MediaStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function __construct(private MediaStorageService $storage) {}

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'music' => ['required', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'],
        ]);

        $old = Setting::get('background_music_path');
        $path = $old
            ? $this->storage->replace($old, $request->file('music'), 'music')
            : $this->storage->store($request->file('music'), 'music');

        Setting::set('background_music_path', $path);

        return back()->with('status', 'Musique ajoutee.');
    }

    public function destroy(): RedirectResponse
    {
        $path = Setting::get('background_music_path');
        $this->storage->delete($path);
        Setting::set('background_music_path', null);

        return back()->with('status', 'Musique retiree.');
    }
}