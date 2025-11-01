<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospedaje extends Model
{
    protected $table = 'hospedajes';
    protected $primaryKey = 'id_hospedaje';
    
    protected $fillable = [
        'id_anfitrion',
        'titulo',
        'ubicacion',
        'descripcion',
        'precio',
        'capacidad',
        'fotos',
        'disponible',
        'wifi',
        'cocina',
        'estacionamiento'
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'wifi' => 'boolean',
        'cocina' => 'boolean',
        'estacionamiento' => 'boolean',
        'precio' => 'decimal:2'
    ];

    // Relaciones
    public function anfitrion()
    {
        return $this->belongsTo(Usuario::class, 'id_anfitrion', 'id_usuario');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_hospedaje', 'id_hospedaje');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'id_hospedaje', 'id_hospedaje');
    }

    // Métodos auxiliares
    public function promedioCalificacion()
    {
        return $this->resenas()->avg('calificacion');
    }

    public function totalResenas()
    {
        return $this->resenas()->count();
    }

    public function getFotosArray()
    {
        return json_decode($this->fotos, true) ?? [];
    }
}
