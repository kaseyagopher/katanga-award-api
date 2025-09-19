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
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet');
            $table->text('description');
            $table->string('photo_url');

            $table->unsignedBigInteger('categorie_id');
            $table->unsignedBigInteger('edition_id');

            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('edition_id')->references('id')->on('editions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
