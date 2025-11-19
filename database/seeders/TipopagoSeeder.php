<?php

namespace Database\Seeders;

use App\Models\TipoPago;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipopagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipopago')->insert([
            [
                'nombre' => 'cheque',
                'descripcion' => 'Pago por medio de cheque a nombre de la empresa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'tarjeta',
                'descripcion' => 'Pago por medio de tarjeta de debito o credito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'efectivo',
                'descripcion' => 'Pago por medio de dinero fisico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
