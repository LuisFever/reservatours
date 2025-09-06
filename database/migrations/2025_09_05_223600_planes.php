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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Gratis, Mensual, Anual
            $table->decimal('precio', 8, 2)->default(0);
            $table->integer('duracion_dias'); // 30, 365, etc. 0 si es ilimitado
            $table->integer('limite_paquetes')->nullable(); // ej. 1 en gratis, null en ilimitado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
