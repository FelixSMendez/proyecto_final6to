<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $fillable = 
    ['nombre', 
    'id_tipoProducto', 
    'descripcion'];

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'id_tipoProducto');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleProducto::class, 'id_producto');
    }
}
