<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TimeCapsuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'friend_id' => ['required', 'exists:friends,id'],
            'content' => ['required', 'string', 'max:3000'],
            'unlock_at' => ['required', 'date'],
        ];
    }
}
