<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    // Forzar el nombre singular de la tabla
    protected $table = 'detallefactura';

    protected $fillable = [
        'id_factura',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'descuento_aplicado',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
