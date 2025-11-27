<?php
// app/Models/Sucursal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $fillable = 
    [
        'nombre', 
        'direccion', 
        'ciudad',
        'latitud',
        'longitud'
    ];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'id_sucursal');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_sucursal');
    }
}
