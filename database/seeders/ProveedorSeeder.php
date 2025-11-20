<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedor')->insert([
            [
                'nombre' => 'Pinturas Patito',
                'contacto' => 'Julian',
                'direccion' => 'Guatemala',
                'telefono' => '87546532',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Truper',
                'contacto' => 'Mariana',
                'direccion' => 'Huehuetenango',
                'telefono' => '45632198',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Quimicos S.A.',
                'contacto' => 'Pedro',
                'direccion' => 'Baja Verapaz',
                'telefono' => '45217896',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
