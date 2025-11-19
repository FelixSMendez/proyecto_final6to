<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $table = 'precio';
    protected $fillable = [
        'id_detalleproducto',
        'tipo',
        'cantidadminima',
        'cantidadmaxima',
        'precioVenta',
        'tipo_cliente'
    ];

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleproducto');
    }
}
