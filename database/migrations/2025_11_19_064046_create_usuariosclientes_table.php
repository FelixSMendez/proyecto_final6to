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
        Schema::create('usuariosclientes', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 50);
            $table->string('contrasena', 200);
            $table->string('correo_electronico', 100);
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuariosclientes');
    }
};
