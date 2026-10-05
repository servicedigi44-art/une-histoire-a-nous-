<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'title',
        'slug',
        'intro_text',
        'outro_text',
        'cover_photo_path',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'number' => 'integer',
        ];
    }

    public function memories()
    {
        return $this->hasMany(Memory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('number');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
