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
        Schema::create('publicacions', function (Blueprint $table) {
            $table->id(column: 'IdPublicacion');
            $table->unsignedBigInteger(column: 'IdProyecto');
            $table->unsignedBigInteger(column: 'IdGeneradorContenido');
            $table->String(column: 'RedSocial');
            $table->String(column: 'IdPublicacionRedSocial');
            $table->String(column: 'Hashtag');
            $table->integer(column: 'Vistas');
            $table->String(column: 'Comentarios');
            $table->integer(column: 'Engagement');
            $table->String(column: 'TipoPublicacion');
            $table->String(column: 'Url');
            $table->timestamps();

            $table->foreign('IdGeneradorContenido')->references('IdUsuario')->on('generador_contenidos')->onDelete('cascade');
            $table->foreign('IdProyecto')->references('IdProyecto')->on('proyectos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacions');
    }
};
