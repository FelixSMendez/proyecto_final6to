<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run()
    {
        DB::table('rol')->insert([
            [
                'tipo' => 'digitador',
                'descripcion' => 'Rol para gestionar productos e inventario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'cajero',
                'descripcion' => 'Rol para realizar ventas y facturación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'gerente',
                'descripcion' => 'Rol para ver reportes y gestionar sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
