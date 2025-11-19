<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';

    protected $fillable = [
        'correlativo',
        'letra_serie',
        'fecha',
        'id_cliente',
        'id_empleado',
        'id_sucursal',
        'total',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'float',
        'estado' => 'string',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'id_factura');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_factura');
    }
}
