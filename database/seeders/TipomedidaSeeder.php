<?php

namespace Database\Seeders;

use App\Models\TipoMedida;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipomedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipomedida')->insert([
            [
                'tipo' => 'Litros',
                'descripcion' => 'Medida en litros para productos líquidos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'Pulgadas',
                'descripcion' => 'Medida en pulgadas para productos sólidos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
