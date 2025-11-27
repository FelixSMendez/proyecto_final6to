<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        'nombre',
        'email',
        'direccion',
        'telefono',
        'tipo',
        'latitud',
        'longitud',
    ];

    public function tieneGps()
    {
        return !is_null($this->latitud) && !is_null($this->longitud);
    }
}
