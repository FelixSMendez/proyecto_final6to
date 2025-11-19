<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';

    protected $fillable = [
        'nombre',
        'stock',
        'id_tipoProducto',
        'id_proveedor',
        'id_detalleProducto',
        'id_precio',
    ];

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'id_tipoProducto');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleProducto');
    }

    public function precio()
    {
        return $this->belongsTo(Precio::class, 'id_precio');
    }
}
