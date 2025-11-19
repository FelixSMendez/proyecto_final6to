<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lote';

    protected $fillable = [
        'cantidad',
        'costoUnidad',
        'fechaCaducidad',
        'fechaEntrada',
        'codLote',
        'descripcion',
        'id_producto',
        'id_marca',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }
}
