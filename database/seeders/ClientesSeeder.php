<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('cliente')->insert([
            [
                'nombre' => 'Juan Morales',
                'email' => 'juan@cliente.com',
                'direccion' => '5ta Avenida 10-45, Zona 1, Ciudad de Guatemala',
                'telefono' => '5555-1234',
                'gps' => '14.634915, -90.506882',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Maria Lopez',
                'email' => 'maria@cliente.com',
                'direccion' => '3ra Calle 20-30, Zona 2, Ciudad de Guatemala',
                'telefono' => '5555-5678',
                'gps' => '14.634000, -90.507000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Construcciones XYZ',
                'email' => 'empresa@cliente.com',
                'direccion' => 'Av. Reforma 15-60, Zona 10, Ciudad de Guatemala',
                'telefono' => '5555-9012',
                'gps' => '14.634500, -90.508000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
