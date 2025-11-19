<?php

namespace Database\Seeders;

use App\Models\DetalleProducto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleproductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detalleproducto')->insert([
            [
                'id_producto' => 1,
                'id_marca' => 1,
                'id_tipomedida' => 1,
                'color_acabado' => 'Blanco Mate',
                'descripcion' => 'Pintura acrílica blanca de alta calidad con acabado mate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_producto' => 2,
                'id_marca' => 2,
                'id_tipomedida' => 2,
                'color_acabado' => 'N/A',
                'descripcion' => 'Rodillo de alta densidad para una aplicación uniforme de pintura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
