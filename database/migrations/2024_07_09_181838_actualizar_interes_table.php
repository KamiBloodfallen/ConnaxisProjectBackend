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
        Schema::table('interes', function (Blueprint $table) {
            // Cambiar el nombre de la columna
            $table->renameColumn('IdUsuario', 'IdUsu');
            
            // Modificar las columnas para permitir nulos
            $table->boolean('Familia')->nullable()->change();
            $table->boolean('Deportes')->nullable()->change();
            $table->boolean('Comida')->nullable()->change();
            $table->boolean('Turismo')->nullable()->change();
            $table->boolean('Baile')->nullable()->change();
            $table->boolean('Fitness')->nullable()->change();
            
            // Añadir la clave foránea
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
        Schema::table('interes', function (Blueprint $table) {
            // Revertir los cambios en el método down
            $table->renameColumn('IdUsu', 'IdUsuario');
            
            // Modificar las columnas para quitar los nulos
            $table->boolean('Familia')->nullable(false)->change();
            $table->boolean('Deportes')->nullable(false)->change();
            $table->boolean('Comida')->nullable(false)->change();
            $table->boolean('Turismo')->nullable(false)->change();
            $table->boolean('Baile')->nullable(false)->change();
            $table->boolean('Fitness')->nullable(false)->change();
            
            // Eliminar la clave foránea
            $table->dropForeign(['IdUsu']);
        });
    }
};
