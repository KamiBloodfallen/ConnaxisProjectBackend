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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id(column: 'IdProyecto');
            $table->String(column: 'NombreProyecto');
            $table->String(column: 'Descripcion');
            $table->unsignedBigInteger(column: 'IdAgencia');
            $table->String(column: 'Fecha');
            $table->integer(column: 'IdBriefing');
            $table->String(column: 'Proyectocol');
            $table->timestamps();

            $table->foreign('IdAgencia')->references('IdAgencia')->on('agencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
