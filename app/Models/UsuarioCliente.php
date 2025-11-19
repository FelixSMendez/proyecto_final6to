<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioCliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuariosclientes';

    protected $fillable = [
        'usuario',
        'correo_electronico',
        'contrasena',
        'id_cliente',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'contrasena' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function getNombre()
    {
        return $this->cliente->nombre ?? $this->usuario;
    }
}