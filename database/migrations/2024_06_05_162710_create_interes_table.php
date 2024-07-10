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
        Schema::create('interes', function (Blueprint $table) {
            $table->id(column: 'IdUsu');
            $table->string(column: 'Intereses_Usuario');
            $table->timestamps();
            
            $table->foreign('IdUsu')->references('IdUsuario')->on('generador_contenidos')
                  ->onDelete('NO ACTION')
                  ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interes');
    }
};
