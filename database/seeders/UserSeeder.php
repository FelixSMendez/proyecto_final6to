<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuariosistema')->insert([
            [
                'usuario' => 'digitador',
                'contrasena' => Hash::make('123456'),
                'id_empleado' => 1,  // Juan - Digitador
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usuario' => 'cajero',
                'contrasena' => Hash::make('123456'),
                'id_empleado' => 2,  // María - Cajero
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'usuario' => 'gerente',
                'contrasena' => Hash::make('123456'),
                'id_empleado' => 3,  // Roberto - Gerente
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
