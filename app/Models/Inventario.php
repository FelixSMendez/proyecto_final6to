<?php
// app/Models/Inventario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $fillable = [
        'existencia',
        'id_detalleproducto',
        'id_sucursal',
        'stock_minimo',
        'stock_maximo',
        'stock_actual'
    ];

    public function detalleProducto()
    {
        return $this->belongsTo(DetalleProducto::class, 'id_detalleproducto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_sucursal', 'id_sucursal')
                    ->where('id_detalleproducto', $this->id_detalleproducto);
    }
}
