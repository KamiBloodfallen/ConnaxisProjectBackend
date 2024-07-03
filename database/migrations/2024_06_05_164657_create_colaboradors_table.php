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
        Schema::create('colaboradors', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'IdProyecto');
            $table->unsignedBigInteger(column: 'IdGeneradorContenido');
            $table->date(column: 'FechaColaboracion');
            $table->timestamps();

            $table->foreign('IdProyecto')->references('IdProyecto')->on('proyectos')->onDelete('cascade');
            $table->foreign('IdGeneradorContenido')->references('IdUsuario')->on('generador_contenidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradors');
    }
};
