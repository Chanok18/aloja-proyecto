<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospedajeFoto extends Model
{
    protected $table = 'hospedaje_fotos';
    protected $primaryKey = 'id_foto';
    
    protected $fillable = [
        'id_hospedaje',
        'ruta_foto',
        'es_principal',
        'orden'
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'orden' => 'integer'
    ];

    // Relación: Una foto pertenece a un hospedaje
    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class, 'id_hospedaje', 'id_hospedaje');
    }

    // Helper: URL completa de la foto
    public function urlCompleta()
    {
        return asset('storage/' . $this->ruta_foto);
    }
}