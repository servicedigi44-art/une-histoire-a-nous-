<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_id')->nullable()->constrained('memories')->cascadeOnDelete();
            $table->foreignId('friend_id')->nullable()->constrained('friends')->nullOnDelete();
            $table->string('type'); // image | video
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('caption')->nullable();
            // utilisé pour les sliders avant/après ("before" ou "after")
            $table->string('role')->nullable();
            $table->unsignedInteger('size_bytes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
