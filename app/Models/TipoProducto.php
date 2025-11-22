<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipoproducto';
    protected $fillable = ['tipo', 'descripcion'];

    public function productos() {
        return $this->hasMany(Producto::class, 'id_tipoProducto');
    }
}
