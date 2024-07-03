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
        Schema::create('tiktoks', function (Blueprint $table) {
            $table->id(column: 'IdTiktok');
            $table->unsignedBigInteger(column: 'IdGeneradorContenido');
            $table->String(column: 'TokenAcces');
            $table->String(column: 'IdCuenta');
            $table->integer(column: 'CantVideos');
            $table->integer(column: 'CantSeguidores');
            $table->integer(column: 'CantLikes');
            $table->integer(column: 'Engagement');
            $table->timestamps();

            $table->foreign('IdGeneradorContenido')->references('IdUsuario')->on('generador_contenidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiktoks');
    }
};
