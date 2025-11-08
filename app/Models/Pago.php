<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    public $timestamps = false;
    
    protected $fillable = [
        'id_reserva',
        'monto',
        'metodo',              // ← Tu BD usa "metodo"
        'estado_pago',         // ← Tu BD usa "estado_pago"
        'fecha_pago',
        'referencia_pago'      // ← Tu BD usa "referencia_pago"
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime'
    ];

    // Relaciones
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    // Métodos auxiliares
    public function estaPendiente()
    {
        return $this->estado_pago === 'pendiente';
    }

    public function estaCompletado()
    {
        return $this->estado_pago === 'completado';
    }

    public function estaFallido()
    {
        return $this->estado_pago === 'fallido';
    }

    public function estaReembolsado()
    {
        return $this->estado_pago === 'reembolsado';
    }
}