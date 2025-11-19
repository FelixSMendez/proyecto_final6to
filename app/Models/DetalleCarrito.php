<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCarrito extends Model
{
    use HasFactory;

    protected $table = 'detallecarrito';

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
