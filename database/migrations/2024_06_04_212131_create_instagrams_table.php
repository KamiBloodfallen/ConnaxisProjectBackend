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
            $table->id('IdInstagram');
            $table->unsignedBigInteger('IdGeneradorContenido');
            $table->integer('TokenAcces')->nullable();
            $table->integer('IdCuenta');
            $table->date('TokenTime')->nullable();
            $table->string('NombreCuenta')->nullable();
            $table->string('ImgCuenta')->nullable();
            $table->integer('CantPublicaciones')->nullable();
            $table->integer('CantSeguidores')->nullable();
            $table->integer('CantLikes')->nullable();
            $table->integer('Engagement')->nullable();
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
