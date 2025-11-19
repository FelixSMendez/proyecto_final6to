<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    public function run()
    {
        DB::table('sucursal')->insert([
            [
                'nombre' => 'Pradera Chimaltenango',
                'direccion' => 'Blvd. Pradera',
                'ciudad' => 'Chimaltenango',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pradera Escuintla',
                'direccion' => 'Centro Comercial Pradera',
                'ciudad' => 'Escuintla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Las Américas Mazatenango',
                'direccion' => 'Zona 3',
                'ciudad' => 'Mazatenango',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'La Trinidad Coatepeque',
                'direccion' => 'Zona Centro',
                'ciudad' => 'Coatepeque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pradera Xela',
                'direccion' => 'Paseo de Xela',
                'ciudad' => 'Quetzaltenango',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Centro Comercial Miraflores',
                'direccion' => 'Zona 10',
                'ciudad' => 'Ciudad de Guatemala',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
