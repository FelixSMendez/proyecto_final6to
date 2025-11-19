<?php

namespace Database\Seeders;

use App\Models\TipoProducto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoproductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipoproducto')->insert([
            [
                'tipo' => 'Pintura',
                'descripcion' => 'Productos relacionados con pinturas y recubrimientos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'Accesorios',
                'descripcion' => 'Productos complementarios y accesorios para pinturas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
