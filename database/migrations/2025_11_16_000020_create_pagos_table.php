<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_factura');
            $table->decimal('monto', 10, 2)->nullable();
            $table->unsignedBigInteger('id_tipo_pago');

            // Campos adicionales
            $table->string('no_tarjeta', 30)->nullable();
            $table->string('no_cheque', 30)->nullable();
            $table->decimal('cambio', 10, 2)->nullable();
            $table->date('fecha_expiracion')->nullable();

            $table->foreign('id_factura')->references('id')->on('factura');
            $table->foreign('id_tipo_pago')->references('id')->on('tipopago');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
