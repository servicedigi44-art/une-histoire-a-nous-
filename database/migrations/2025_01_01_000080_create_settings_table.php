<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Table clé/valeur pour les textes et réglages globaux configurables
    // (ex: date par défaut de la capsule, titre du site, activation musique...)
    // afin de ne jamais coder en dur une valeur comme "2036" à plusieurs endroits.
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
