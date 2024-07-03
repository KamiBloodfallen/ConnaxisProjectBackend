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
            $table->id(column: 'IdUsuario');
            $table->boolean(column: 'Familia');
            $table->boolean(column: 'Deportes');
            $table->boolean(column: 'Comida');
            $table->boolean(column: 'Turismo');
            $table->boolean(column: 'Baile');
            $table->boolean(column: 'Fitness');
            $table->timestamps();
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
