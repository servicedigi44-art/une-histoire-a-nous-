<?php

use App\Models\Friend;
use App\Models\Media;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Support\Facades\URL;

if (!function_exists('media_url')) {
    function media_url(?Media $media, string $variant = 'file'): ?string
    {
        if (!$media) {
            return null;
        }

        return URL::temporarySignedRoute('media.show', now()->addMinutes(30), [
            'media' => $media->id,
            'variant' => $variant,
        ]);
    }
}

if (!function_exists('media_url_for_slide')) {
    function media_url_for_slide(?Slide $slide, string $variant = 'file'): ?string
    {
        if (!$slide) {
            return null;
        }

        return URL::temporarySignedRoute('media.slide', now()->addMinutes(30), [
            'slide' => $slide->id,
            'variant' => $variant,
        ]);
    }
}

if (!function_exists('friend_photo_url')) {
    function friend_photo_url(?Friend $friend, string $stage): ?string
    {
        if (!$friend) {
            return null;
        }

        $column = match ($stage) {
            'child' => 'photo_child_path',
            'teen' => 'photo_teen_path',
            'now' => 'photo_now_path',
            default => null,
        };

        if (!$column || !$friend->{$column}) {
            return null;
        }

        return URL::temporarySignedRoute('media.friend-photo', now()->addMinutes(30), [
            'friend' => $friend->id,
            'stage' => $stage,
        ]);
    }
}

if (!function_exists('music_url')) {
    function music_url(): ?string
    {
        if (!Setting::get('background_music_path')) {
            return null;
        }

        return URL::temporarySignedRoute('media.music', now()->addHours(2), []);
    }
}