<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->enum('estado', ['activo', 'finalizado', 'cancelado'])->default('activo');
            $table->foreign('id_usuario')->references('id')->on('usuariosistema');
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito');
    }
};
