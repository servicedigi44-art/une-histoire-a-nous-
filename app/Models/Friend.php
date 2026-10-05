<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'bio',
        'birth_year',
        'photo_child_path',
        'photo_teen_path',
        'photo_now_path',
        'profile_photo',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'birth_year' => 'integer',
        ];
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(PersonalMessage::class, 'author_friend_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(PersonalMessage::class, 'recipient_friend_id');
    }

    public function timeCapsules()
    {
        return $this->hasMany(TimeCapsule::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Statistiques affichées sur le profil (chapitre 06)
    public function memoriesCount(): int
    {
        return Media::where('friend_id', $this->id)
            ->distinct('memory_id')
            ->count('memory_id');
    }

    public function photosCount(): int
    {
        return $this->media()->where('type', 'image')->count();
    }

    public function videosCount(): int
    {
        return $this->media()->where('type', 'video')->count();
    }

    public function friendshipYears(): ?int
    {
        if (!$this->birth_year) {
            return null;
        }
        // Nombre d'années depuis la première année configurée du site (chapitre 01)
        $firstYear = (int) Setting::get('story_start_year', now()->year);
        return max(0, now()->year - $firstYear);
    }
}
