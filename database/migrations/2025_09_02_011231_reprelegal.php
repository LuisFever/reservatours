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
        Schema::create('reprelegal', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('fk_idempresas')->nullable();
            $table->unsignedBigInteger('fk_idpersonas')->nullable(); // Nueva clave foránea
            $table->timestamps();

            // Las relaciones
            $table->foreign('fk_idempresas')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('fk_idpersonas')->references('id')->on('personas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reprelegal');
    }
};
