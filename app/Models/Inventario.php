<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    
    protected $fillable = [
        'existencia',
        'id_detalleproducto',
        'id_sucursal',
        'stock_minimo',
        'stock_maximo',
        'stock_actual',
    ];

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleproducto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
}
