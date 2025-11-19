<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        DB::table('empleado')->insert([
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez López',
                'email' => 'juan.perez@paints.com',
                'id_rol' => 1,  // Digitador
                'id_sucursal' => 1,  // Chimaltenango
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'García Rodríguez',
                'email' => 'maria.garcia@paints.com',
                'id_rol' => 2,  // Cajero
                'id_sucursal' => 2,  // Escuintla
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Roberto',
                'apellido' => 'Martínez López',
                'email' => 'roberto.martinez@paints.com',
                'id_rol' => 3,  // Gerente
                'id_sucursal' => 6,  // Miraflores Guatemala
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
