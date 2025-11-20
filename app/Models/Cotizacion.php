<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';
    protected $fillable = [
        'id_cliente', 'fecha', 'fecha_vencimiento', 'total', 
        'estado', 'pdf_path'
    ];
    protected $casts = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCotizacion::class, 'id_cotizacion');
    }
}