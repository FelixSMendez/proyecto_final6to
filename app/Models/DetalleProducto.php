<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    use HasFactory;

    protected $table = 'detalleproducto';
    protected $fillable = [
        'id_marca',
        'id_producto',
        'id_tipoMedida',
        'color_acabado',
        'descripcion',
    ];

    public function tipoMedida()
    {
        return $this->belongsTo(TipoMedida::class, 'id_tipoMedida');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    // Relación con precios (puede tener múltiples precios según tipo_cliente)
    public function precios()
    {
        return $this->hasMany(Precio::class, 'id_detalleproducto');
    }

    // Obtener el precio de venta para un tipo de cliente específico
    public function obtenerPrecio($tipoCliente)
    {
        return $this->precios()
            ->where('tipo_cliente', $tipoCliente)
            ->first()?->precioVenta ?? 0;
    }
}
