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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tipoDescuento');
            $table->unsignedBigInteger('id_detalleProducto');
            $table->decimal('valor', 10, 2);
            $table->integer('cantidadMinima')->nullable();
            $table->integer('cantidadMaxima')->nullable();
            $table->date('fechaInicio');
            $table->date('fechaFin')->nullable();
            $table->foreign('id_tipoDescuento')->references('id')->on('tiposdescuento');
            $table->foreign('id_detalleProducto')->references('id')->on('detalleproducto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
