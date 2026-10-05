<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_friend_id')->constrained('friends')->cascadeOnDelete();
            $table->foreignId('recipient_friend_id')->constrained('friends')->cascadeOnDelete();
            $table->text('content');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_messages');
    }
};
