<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeCapsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'friend_id',
        'content',
        'unlock_at',
        'is_unlocked',
    ];

    protected function casts(): array
    {
        return [
            'unlock_at' => 'datetime',
            'is_unlocked' => 'boolean',
        ];
    }

    public function friend()
    {
        return $this->belongsTo(Friend::class);
    }

    // Seule source de vérité : la date, vérifiée côté serveur à chaque accès.
    // Le champ is_unlocked n'est qu'un cache mis à jour ici, jamais la condition d'accès.
    public function isOpen(): bool
    {
        return now()->greaterThanOrEqualTo($this->unlock_at);
    }
}
