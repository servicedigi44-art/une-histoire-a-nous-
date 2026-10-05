<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PersonalMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'author_friend_id' => ['required', 'exists:friends,id', 'different:recipient_friend_id'],
            'recipient_friend_id' => ['required', 'exists:friends,id'],
            'content' => ['required', 'string', 'max:2000'],
            'is_visible' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'author_friend_id.different' => "L'auteur et le destinataire doivent être différents.",
        ];
    }
}
