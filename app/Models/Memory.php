<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    use HasFactory;

    public const TYPES = ['photo', 'video', 'timeline', 'before_after', 'special'];

    protected $fillable = [
        'chapter_id',
        'year',
        'title',
        'description',
        'anecdote',
        'memory_type',
        'category',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'year' => 'integer',
        ];
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('year');
    }
}
