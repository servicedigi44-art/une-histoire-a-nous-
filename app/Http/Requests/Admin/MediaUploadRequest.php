<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'memory_id' => ['nullable', 'exists:memories,id'],
            'friend_id' => ['nullable', 'exists:friends,id'],
            'type' => ['required', 'in:image,video'],
            'role' => ['nullable', 'in:before,after'],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            // images : 5 Mo max / vidéos : 50 Mo max (ajustable selon hébergement réel)
            'file' => [
                'required', 'file',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $type = $this->input('type');
                    $allowedImage = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    $allowedVideo = ['mp4', 'mov', 'webm'];
                    $ext = strtolower($value->getClientOriginalExtension());

                    if ($type === 'image') {
                        if (!in_array($ext, $allowedImage)) {
                            $fail("Format d'image non autorisé.");
                        }
                        if ($value->getSize() > 5 * 1024 * 1024) {
                            $fail("L'image dépasse 5 Mo.");
                        }
                    } elseif ($type === 'video') {
                        if (!in_array($ext, $allowedVideo)) {
                            $fail("Format vidéo non autorisé.");
                        }
                        if ($value->getSize() > 50 * 1024 * 1024) {
                            $fail('La vidéo dépasse 50 Mo.');
                        }
                    }
                },
            ],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }
}
