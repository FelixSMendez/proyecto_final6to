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
        'razon_anulacion',
        'fecha_anulacion',
        'id_empleado_anulacion'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'float',
        'estado' => 'string',
    ];

    // MUTADOR para manejar fecha_anulacion correctamente
    public function setFechaAnulacionAttribute($value)
    {
        if ($value === null) {
            $this->attributes['fecha_anulacion'] = null;
        } elseif ($value instanceof \DateTime || $value instanceof \Illuminate\Support\Carbon) {
            $this->attributes['fecha_anulacion'] = $value->format('Y-m-d H:i:s');
        } else {
            $this->attributes['fecha_anulacion'] = $value;
        }
    }

    public function cliente()
    {
        return $this->belongsTo(UsuarioCliente::class, 'id_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function empleadoAnulacion()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado_anulacion');
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
