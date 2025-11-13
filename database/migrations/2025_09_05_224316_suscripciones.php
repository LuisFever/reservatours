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
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->enum('plan', ['gratis', 'mensual', 'anual']);
            $table->date('fecha_inicio')->default(now());
            $table->date('fecha_fin')->nullable();
            $table->boolean('activa')->default(true);
            $table->unsignedBigInteger('fk_idusuarios')->nullable();
            $table->timestamps();

            $table->foreign('fk_idusuarios')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};
