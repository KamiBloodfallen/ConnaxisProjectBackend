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
        Schema::create('instagrams', function (Blueprint $table) {
            $table->id(column: 'IdInstagram');
            $table->unsignedBigInteger(column: 'IdGeneradorContenido');
            $table->integer(column: 'TokenAcces');
            $table->integer(column: 'IdCuenta');
            $table->String(column: 'NombreCuenta');
            $table->integer(column: 'CantPublicaciones');
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
        Schema::dropIfExists('instagrams');
    }
};
