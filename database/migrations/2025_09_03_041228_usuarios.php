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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('fk_idpersonas')->nullable();
            $table->unsignedBigInteger('fk_idempresas')->nullable();
            $table->unsignedBigInteger('fk_idtipousuarios')->nullable();
            $table->timestamps();

            $table->foreign('fk_idpersonas')->references('id')->on('personas')->onDelete('set null');
            $table->foreign('fk_idempresas')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('fk_idtipousuarios')->references('id')->on('tipousuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
