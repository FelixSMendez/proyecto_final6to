<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalleproducto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_marca');
            $table->unsignedBigInteger('id_tipoMedida');
            $table->string('color_acabado', 50)->nullable();
            $table->string('descripcion', 200)->nullable();
            $table->timestamps();

            $table->foreign('id_producto')->references('id')->on('producto');
            $table->foreign('id_marca')->references('id')->on('marcas');
            $table->foreign('id_tipoMedida')->references('id')->on('tipomedida');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalleproducto');
    }
};
