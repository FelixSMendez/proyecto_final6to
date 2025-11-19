<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->date('fecha');
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'vencida'])->default('pendiente');
            $table->string('pdf_path')->nullable();
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion');
    }
};
