<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'telefono',
        'fecha_nacimiento',
        'rol',
        'estado'
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    // Sobrescribir métodos de autenticación
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    // Relaciones
    public function hospedajes()
    {
        return $this->hasMany(Hospedaje::class, 'id_anfitrion', 'id_usuario');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'id_usuario', 'id_usuario');
    }

    public function conversacionesChatbot()
    {
        return $this->hasMany(ChatbotConversacion::class, 'id_usuario', 'id_usuario');
    }

    // Métodos auxiliares
    public function esAnfitrion()
    {
        return $this->rol === 'anfitrion';
    }

    public function esAdmin()
    {
        return $this->rol === 'admin';
    }

    public function esViajero()
    {
        return $this->rol === 'viajero';
    }
}