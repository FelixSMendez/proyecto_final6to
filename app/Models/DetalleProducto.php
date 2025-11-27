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
     public function obtenerPrecio($tipoCliente = 'minorista', $cantidad = 1)
    {
        $precio = $this->precios()
            ->where('tipo_cliente', $tipoCliente)
            ->where(function ($query) use ($cantidad) {
                // Si cantidadminima es null O cantidad >= cantidadminima
                $query->whereNull('cantidadminima')
                      ->orWhere('cantidadminima', '<=', $cantidad);
            })
            ->where(function ($query) use ($cantidad) {
                // Si cantidadmaxima es null O cantidad <= cantidadmaxima
                $query->whereNull('cantidadmaxima')
                      ->orWhere('cantidadmaxima', '>=', $cantidad);
            })
            ->orderBy('cantidadminima', 'desc')
            ->first();

        return $precio ? (float) $precio->precioVenta : 0;
    }
}
