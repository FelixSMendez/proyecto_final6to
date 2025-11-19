<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $table = 'precio';

    protected $fillable = [
        'tipo',
        'precioVenta',
        'descuento',
        'id_tipoMedida',
    ];

    // Relación con TipoMedida
    public function tipoMedida()
    {
        return $this->belongsTo(TipoMedida::class, 'id_tipoMedida');
    }
}
