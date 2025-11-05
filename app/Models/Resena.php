<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $table = 'resenas';
    protected $primaryKey = 'id_resena';
    public $timestamps = false;
    
    protected $fillable = [
        'id_reserva',
        'id_usuario',
        'id_hospedaje',
        'calificacion',
        'comentario',
        'fecha_resena'
    ];

    protected $casts = [
        'fecha_resena' => 'datetime',
        'calificacion' => 'integer'
    ];

    // Relaciones
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class, 'id_hospedaje', 'id_hospedaje');
    }
}
