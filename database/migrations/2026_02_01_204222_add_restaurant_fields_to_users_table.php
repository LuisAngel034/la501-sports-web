<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Datos extra para el restaurante
            $table->string('telefono')->nullable();
            $table->string('pregunta_secreta')->nullable(); // Criterio: Pregunta secreta segura [cite: 3]
            $table->string('respuesta_secreta')->nullable(); // Se guardará con Hash [cite: 3]
            $table->string('direccion_favorita')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
