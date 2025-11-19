<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    use HasFactory;

    protected $table = 'detalleproducto';

    protected $fillable = [
        'id_tipoMedida',
        'color',
        'descripcion',
    ];

    public function tipoMedida()
    {
        return $this->belongsTo(TipoMedida::class, 'id_tipoMedida');
    }
}
