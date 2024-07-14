<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generador_contenidos', function (Blueprint $table) {
            $table->id(column:'IdUsuario');
            $table->String (column: 'Nombre');
            $table->String(column: 'Apellido');
            $table->integer(column: 'Celular');
            $table->String(column: 'CorreoElectronico')->unique();
            $table->date(column: 'FechaNacimiento');
            $table->String(column: 'Descripcion')->nullable();
            $table->String(column: 'Sexo');
            $table->String(column: 'password');
            $table->String(column: 'ResidenciaDepartamento');
            $table->String(column: 'Nombre_perfil')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generador_contenidos');
    }
};
