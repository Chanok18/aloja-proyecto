<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hospedaje extends Model
{
    protected $table = 'hospedajes';
    protected $primaryKey = 'id_hospedaje';
    
    #Campos que se pueden asignar masivamente
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
        'precio' => 'decimal:2',
        'disponible' => 'boolean',
        'wifi' => 'boolean',
        'cocina' => 'boolean',
        'estacionamiento' => 'boolean'
    ];

    public function anfitrion()
    {
        return $this->belongsTo(Usuario::class, 'id_anfitrion', 'id_usuario');
    }

    
    #Un hospedaje tiene muchas reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_hospedaje', 'id_hospedaje');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'id_hospedaje', 'id_hospedaje');
    }

    public function promedioCalificacion()
    {
        return $this->resenas()->avg('calificacion') ?? 0;
    }

    public function totalResenas()
    {
        return $this->resenas()->count();
    }
}