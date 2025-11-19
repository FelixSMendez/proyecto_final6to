<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            [
                'marca' => 'GOLDEN ART',
                'descripcion' => 'Pinturas y recubrimientos de alta calidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'marca' => 'Truper',
                'descripcion' => 'Herramientas y accesorios para construcción y pintura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
