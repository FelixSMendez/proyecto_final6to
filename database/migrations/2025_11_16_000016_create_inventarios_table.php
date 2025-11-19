<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->integer('existencia')->default(0);
            $table->unsignedBigInteger('id_detalleproducto');
            $table->unsignedBigInteger('id_sucursal');
            $table->integer('stock_minimo')->default(5);
            $table->integer('stock_maximo')->default(100);
            $table->integer('stock_actual')->default(0);
            $table->foreign('id_detalleproducto')->references('id')->on('detalleproducto');
            $table->foreign('id_sucursal')->references('id')->on('sucursal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
