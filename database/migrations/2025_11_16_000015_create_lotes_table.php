<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lote', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_detalleproducto');
            $table->unsignedBigInteger('id_sucursal');
            $table->unsignedBigInteger('id_proveedor');
            $table->integer('cantidad');
            $table->integer('cantidad_actual');
            $table->decimal('costoUnidad', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->date('fechaCaducidad');
            $table->date('fechaEntrada');
            $table->string('codLote', 50);
            $table->string('descripcion', 200)->nullable();
            $table->foreign('id_detalleproducto')->references('id')->on('detalleproducto');
            $table->foreign('id_sucursal')->references('id')->on('sucursal');
            $table->foreign('id_proveedor')->references('id')->on('proveedor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lote');
    }
};
