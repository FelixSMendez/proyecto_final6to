<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detallefactura';
    public $timestamps = true;

    protected $fillable = [
        'id_factura',
        'id_detalleproducto',  
        'cantidad',
        'precio_unitario',
        'descuento_aplicado',
        'subtotal',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleproducto');
    }
}
