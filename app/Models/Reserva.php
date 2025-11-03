<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    
    protected $fillable = [
        'id_usuario',
        'id_hospedaje',
        'fecha_inicio',
        'fecha_fin',
        'total',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'total' => 'decimal:2'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class, 'id_hospedaje', 'id_hospedaje');
    }

    public function pago()
    {
        return $this->hasOne(Pago::class, 'id_reserva', 'id_reserva');
    }

    public function resena()
    {
        return $this->hasOne(Resena::class, 'id_reserva', 'id_reserva');
    }

    // Métodos auxiliares
    public function estaPendiente()
    {
        return $this->estado === 'pendiente';
    }

    public function estaConfirmada()
    {
        return $this->estado === 'confirmada';
    }

    public function estaCancelada()
    {
        return $this->estado === 'cancelada';
    }

    public function estaCompletada()
    {
        return $this->estado === 'completada';
    }

    public function diasReservados()
    {
        return $this->fecha_inicio->diffInDays($this->fecha_fin);
    }
}