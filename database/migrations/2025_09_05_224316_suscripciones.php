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
        // SIN OPCION GRATUITA
        // Schema::create('suscripciones', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('plan', ['mensual', 'anual']);
        //     $table->date('fecha_inicio');
        //     $table->date('fecha_fin');
        //     $table->boolean('activo')->default(true);
        //     $table->unsignedBigInteger('fk_idusuario');
        //     $table->timestamps();

        //     $table->foreign('fk_idusuario')->references('id')->on('usuarios')->onDelete('cascade');
        // });
        // Schema::create('suscripciones', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('usuario_id');
        //     $table->unsignedBigInteger('plan_id');
        //     $table->date('fecha_inicio');
        //     $table->date('fecha_fin')->nullable(); // null = ilimitado
        //     $table->boolean('activa')->default(true);
        //     $table->timestamps();

        //     $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        //     $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');
        // });
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->enum('plan', ['gratis', 'mensual', 'anual']);
            $table->date('fecha_inicio')->default(now());
            $table->date('fecha_fin')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
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
