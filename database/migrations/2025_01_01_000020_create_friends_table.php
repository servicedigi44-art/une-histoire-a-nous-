<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->string('photo_child_path')->nullable();
            $table->string('photo_teen_path')->nullable();
            $table->string('photo_now_path')->nullable();
            // champ historique demandé par le cahier des charges (photo de profil générique)
            $table->string('profile_photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
