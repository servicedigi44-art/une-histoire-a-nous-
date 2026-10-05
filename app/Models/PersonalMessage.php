<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_friend_id',
        'recipient_friend_id',
        'content',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public function author()
    {
        return $this->belongsTo(Friend::class, 'author_friend_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Friend::class, 'recipient_friend_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
