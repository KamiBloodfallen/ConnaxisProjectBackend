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
        Schema::create('propuestas', function (Blueprint $table) {
            $table->id(column: 'IdPropuesta');
            $table->unsignedBigInteger(column: 'IdProyecto');
            $table->unsignedBigInteger(column: 'IdUsuario');
            $table->String (column: 'Fecha');
            $table->String(column: 'DescripcionPropuesta');
            $table->String(column: 'Estado');
            $table->timestamps();

            $table->foreign('IdUsuario')->references('IdUsuario')->on('generador_contenidos')->onDelete('cascade');
            $table->foreign('IdProyecto')->references('IdProyecto')->on('proyectos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propuestas');
    }
};
