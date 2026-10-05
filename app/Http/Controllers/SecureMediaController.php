<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Media;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureMediaController extends Controller
{
    public function show(Request $request, Media $media, string $variant = 'file'): StreamedResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Lien expire ou invalide.');

        $path = $variant === 'thumbnail' && $media->thumbnail_path
            ? $media->thumbnail_path
            : $media->file_path;

        abort_unless(Storage::disk('private')->exists($path), 404);

        return Storage::disk('private')->response($path);
    }

    public function friendPhoto(Request $request, Friend $friend, string $stage): StreamedResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Lien expire ou invalide.');

        $column = match ($stage) {
            'child' => 'photo_child_path',
            'teen' => 'photo_teen_path',
            'now' => 'photo_now_path',
            default => abort(404),
        };

        $path = $friend->{$column};

        abort_unless($path && Storage::disk('private')->exists($path), 404);

        return Storage::disk('private')->response($path);
    }

    public function slide(Request $request, Slide $slide, string $variant = 'file'): StreamedResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Lien expire ou invalide.');

        $path = $variant === 'thumbnail' && $slide->thumbnail_path
            ? $slide->thumbnail_path
            : $slide->file_path;

        abort_unless(Storage::disk('private')->exists($path), 404);

        return Storage::disk('private')->response($path);
    }

    public function music(Request $request): StreamedResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Lien expire ou invalide.');

        $path = Setting::get('background_music_path');

        abort_unless($path && Storage::disk('private')->exists($path), 404);

        return Storage::disk('private')->response($path);
    }
}