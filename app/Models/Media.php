<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'memory_id',
        'friend_id',
        'type',
        'file_path',
        'thumbnail_path',
        'caption',
        'role',
        'size_bytes',
        'sort_order',
    ];

    public function memory()
    {
        return $this->belongsTo(Memory::class);
    }

    public function friend()
    {
        return $this->belongsTo(Friend::class);
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }
}
