<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Centralise l'enregistrement et la suppression des fichiers sur le disque
 * privé "media" afin d'éviter les fichiers orphelins et de garder une
 * organisation cohérente (storage/app/private/media/{dossier}/...).
 */
class MediaStorageService
{
    public function store(UploadedFile $file, string $folder): string
    {
        $safeName = Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());

        return $file->storeAs("media/{$folder}", $safeName, 'private');
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('private')->exists($path)) {
            Storage::disk('private')->delete($path);
        }
    }

    public function replace(?string $oldPath, UploadedFile $newFile, string $folder): string
    {
        $newPath = $this->store($newFile, $folder);
        $this->delete($oldPath);

        return $newPath;
    }
}
