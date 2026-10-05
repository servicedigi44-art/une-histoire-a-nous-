<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_capsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('friend_id')->constrained('friends')->cascadeOnDelete();
            $table->text('content');
            $table->timestamp('unlock_at');
            $table->boolean('is_unlocked')->default(false); // mis à jour par job/accès, la vérité reste la date
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_capsules');
    }
};
