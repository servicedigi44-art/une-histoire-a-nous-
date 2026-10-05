<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'chapter_id' => ['required', 'exists:chapters,id'],
            'year' => ['nullable', 'integer', 'digits:4'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'anecdote' => ['nullable', 'string'],
            'memory_type' => ['required', 'in:photo,video,timeline,before_after,special'],
            'category' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
