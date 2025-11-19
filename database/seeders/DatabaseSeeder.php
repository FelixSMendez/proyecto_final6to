<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
// Orden CORRECTO de ejecución (por dependencias)
        $this->call([
            RolSeeder::class,          // Primero: roles
            SucursalSeeder::class,     // Segundo: sucursales
            EmpleadoSeeder::class,     // Tercero: empleados (depende de rol y sucursal)
            UserSeeder::class, // Cuarto: usuarios (depende de empleado)
        ]);
        
        $this->call([
            ClientesSeeder::class, // Quinto: clientes
            UsuarioClientesSeeder::class, // Sexto: usuarios de clientes (depende de cliente)
        ]);

        $this->call([
            TipoproductoSeeder::class,      // Séptimo: tipos de producto
            MarcaSeeder::class,             // Octavo: marcas
            TipomedidaSeeder::class,        // Noveno: tipos de medida
            ProductoSeeder::class,          // Décimo: productos (depende de tipo de producto y marca)
            DetalleproductoSeeder::class,   // Undécimo: detalles de producto (depende de producto y tipo de medida)
            PrecioSeeder::class,            // Duodécimo: precios (depende de detalle de producto)
            TipopagoSeeder::class           //Treceavo: tipo de pagos
        ]);

    }
}
