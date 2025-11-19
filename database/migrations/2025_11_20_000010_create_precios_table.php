<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('precio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_detalleproducto');
            $table->string('tipo', 50);
            $table->integer('cantidadminima')->nullable();
            $table->integer('cantidadmaxima')->nullable();
            $table->decimal('precioVenta', 10, 2);
            $table->enum('tipo_cliente', ['minorista', 'mayorista', 'distribuidor'])->default('minorista');
            $table->foreign('id_detalleproducto')->references('id')->on('detalleproducto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('precio');
    }
};
