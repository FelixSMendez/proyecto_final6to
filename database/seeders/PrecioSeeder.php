<?php

namespace Database\Seeders;

use App\Models\Precio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('precio')->insert([
            [
                'id_detalleproducto' => 1,
                'tipo' => 'Unitario',
                'precioVenta' => 150.00,
                'tipo_cliente' => 'minorista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_detalleproducto' => 2,
                'tipo' => 'Unitario',
                'precioVenta' => 75.00,
                'tipo_cliente' => 'minorista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
