<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuariosistema';

    // Si no usas timestamps, desactívalo:
    // public $timestamps = false;

    // Si el campo de login es 'usuario' (no 'email'):
    protected $fillable = [
        'usuario', 'contrasena', 'id_empleado', 'id_cliente',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // El campo para contraseña
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function empleado() {
    return $this->belongsTo(Empleado::class, 'id_empleado');
    }


    public function getTipoRolAttribute() {
        return optional($this->empleado)->rol->tipo ?? null;
    }
}
