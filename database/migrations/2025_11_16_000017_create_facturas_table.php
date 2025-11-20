<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->integer('correlativo');
            $table->char('letra_serie', 1)->nullable();
            $table->dateTime('fecha');
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->unsignedBigInteger('id_sucursal');
            $table->enum('estado', ['pendiente', 'pagada', 'cancelada', 'anulada'])->default('pendiente');

            $table->text('razon_anulacion')->nullable();
            $table->dateTime('fecha_anulacion')->nullable();
            $table->unsignedBigInteger('id_empleado_anulacion')->nullable();

            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->foreign('id_empleado')->references('id')->on('empleado');
            $table->foreign('id_sucursal')->references('id')->on('sucursal');
            $table->foreign('id_empleado_anulacion')->references('id')->on('empleado');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
