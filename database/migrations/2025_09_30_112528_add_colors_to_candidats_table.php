<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->string('couleur_dominante')->nullable()->after('photo_url');
            $table->string('couleur_dominante_sombre')->nullable()->after('couleur_dominante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->dropColumn(['couleur_dominante', 'couleur_dominante_sombre']);
        });
    }
};
