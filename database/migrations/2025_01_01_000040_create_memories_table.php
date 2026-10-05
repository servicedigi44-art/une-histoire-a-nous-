<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('anecdote')->nullable();
            $table->string('memory_type')->default('photo'); // photo, video, timeline, before_after, special
            // pour les "dossiers" du chapitre 3 et les catégories libres
            $table->string('category')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['chapter_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memories');
    }
};
