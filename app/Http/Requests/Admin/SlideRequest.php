<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'type' => ['required', 'in:image,video'],
            'caption' => ['nullable', 'string', 'max:255'],
            'slide_date' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'files' => [$isCreate ? 'required' : 'nullable', 'array', 'min:1'],
            'files.*' => [
                'file',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $type = $this->input('type');
                    $allowedImage = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    $allowedVideo = ['mp4', 'mov', 'webm'];
                    $ext = strtolower($value->getClientOriginalExtension());

                    if ($type === 'image') {
                        if (!in_array($ext, $allowedImage)) {
                            $fail("Format d'image non autorise.");
                        }
                        if ($value->getSize() > 5 * 1024 * 1024) {
                            $fail("Une image depasse 5 Mo.");
                        }
                    } elseif ($type === 'video') {
                        if (!in_array($ext, $allowedVideo)) {
                            $fail("Format video non autorise.");
                        }
                        if ($value->getSize() > 50 * 1024 * 1024) {
                            $fail('Une video depasse 50 Mo.');
                        }
                    }
                },
            ],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }
}