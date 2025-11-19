<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('producto')->insert([
            [
                'nombre' => 'Pintura Acrílica Blanca',
                'descripcion' => 'Pintura acrílica de alta calidad para interiores y exteriores',
                'id_tipoproducto' => 1, // Pintura
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Rodillo para Pintura',
                'descripcion' => 'Rodillo de alta densidad para una aplicación uniforme de pintura',
                'id_tipoproducto' => 2, // Accesorios
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
