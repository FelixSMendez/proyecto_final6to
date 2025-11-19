<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioCliente;
use Illuminate\Support\Facades\DB;

class UsuarioClientesSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuariosclientes')->insert([
            [
                'usuario' => 'juan_morales',
                'correo_electronico' => 'juan@cliente.com',
                'contrasena' => Hash::make('123456'),
                'id_cliente' => 1,
            ],
            [
                'usuario' => 'maria_lopez',
                'correo_electronico' => 'maria@cliente.com',
                'contrasena' => Hash::make('123456'),
                'id_cliente' => 2,
            ],
            [
                'usuario' => 'construcciones_xyz',
                'correo_electronico' => 'empresa@cliente.com',
                'contrasena' => Hash::make('123456'),
                'id_cliente' => 3,
            ],
        ]);
    }
}
