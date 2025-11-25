<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatbotConversacion extends Model
{
    protected $table = 'chatbot_conversaciones';
    protected $primaryKey = 'id_conversacion';
    
    protected $fillable = [
        'id_usuario',
        'mensaje_usuario',
        'respuesta_bot',
        'fecha_conversacion'
    ];
    protected $casts = [
        'fecha_conversacion' => 'datetime'
    ];
    #relacion con usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}