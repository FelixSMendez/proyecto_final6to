<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detallefactura', function (Blueprint $table) { // <- singular, coincide con la DB
            $table->id();
            $table->unsignedBigInteger('id_factura');
            $table->unsignedBigInteger('id_detalleproducto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento_aplicado', 5, 2)->nullable();
            $table->decimal('subtotal', 10, 2);
            // Relaciones
            $table->foreign('id_factura')->references('id')->on('factura');
            $table->foreign('id_detalleproducto')->references('id')->on('detalleproducto');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detallefactura');
    }
};
