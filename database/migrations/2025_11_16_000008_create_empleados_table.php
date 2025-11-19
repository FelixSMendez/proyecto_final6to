<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->unsignedBigInteger('id_sucursal')->nullable();
            $table->foreign('id_sucursal')->references('id')->on('sucursal');
            $table->foreign('id_rol')->references('id')->on('rol');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado');
    }
};
