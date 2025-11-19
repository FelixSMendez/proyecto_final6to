<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallecarrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_carrito');
            $table->unsignedBigInteger('id_detalleproducto');
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 10, 2)->nullable();
            
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->foreign('id_carrito')->references('id')->on('carrito');
            $table->foreign('id_detalleproducto')->references('id')->on('detalleproducto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detallecarrito');
    }
};
