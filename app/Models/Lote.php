<?php
// app/Models/Lote.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    protected $fillable = [
        'id_detalleproducto',
        'id_sucursal',
        'id_proveedor',
        'cantidad',
        'cantidad_actual',
        'costoUnidad',
        'precio_venta',
        'fechaCaducidad',
        'fechaEntrada',
        'codLote',
        'descripcion'
    ];

    protected $casts = [
        'fechaCaducidad' => 'date',
        'fechaEntrada' => 'date',
        'costoUnidad' => 'float',
        'precio_venta' => 'float'
    ];

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleproducto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}
