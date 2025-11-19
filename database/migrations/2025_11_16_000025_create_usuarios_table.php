<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuariosistema', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 50);
            $table->string('contrasena', 200);

            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_cliente');

            $table->foreign('id_empleado')->references('id')->on('empleado');
            $table->foreign('id_cliente')->references('id')->on('cliente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuariosistema');
    }
};
