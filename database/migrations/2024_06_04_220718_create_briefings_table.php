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
        Schema::create('briefings', function (Blueprint $table) {
            $table->id(column: 'IdBriefing');
            $table->unsignedBigInteger(column: 'IdProyecto');
            $table->String(column: 'Objetivo');
            $table->String(column: 'PublicoObjetivo');
            $table->String(column: 'RequisitosPoryecto');
            $table->String(column: 'Restricciones');
            $table->String(column: 'Presupuesto');
            $table->date(column: 'FechaInicio');
            $table->date(column: 'FechaFin');
            $table->timestamps();

            $table->foreign('IdProyecto')->references('IdProyecto')->on('proyectos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefings');
    }
};
