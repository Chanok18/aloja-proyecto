<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ChatbotConversacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:500'
        ]);
        $mensajeUsuario = $request->mensaje;
        #Contexto
        $contextoAloja = "Eres un asistente virtual de Aloja, una plataforma de reservas de hospedajes en Perú similar a Airbnb. 
Info clave de Aloja:
- Plataforma para buscar y reservar hospedajes en Perú
- Métodos de pago: Yape, Plin, Tarjeta, PayPal
- Los anfitriones pueden publicar sus propiedades
- Los viajeros pueden buscar por ubicación, precio y capacidad
- Sistema de reseñas y calificaciones
- Reservas instantáneas con confirmación

Responde de manera amigable, concisa (máximo 2-3 líneas) y util. Si te preguntan algo que no sabes sobre Aloja, se honesto pero ayuda con lo que puedas.";

        try {
            #llamar al api
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $contextoAloja
                    ],
                    [
                        'role' => 'user',
                        'content' => $mensajeUsuario
                    ]
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);
            if ($response->successful()) {
                $data = $response->json();
                $respuestaBot = $data['choices'][0]['message']['content'] ?? 'Lo siento, no pude procesar tu mensaje.';
            } else {
                $respuestaBot = 'Lo siento, estoy teniendo problemas técnicos. Por favor, intenta de nuevo.';
            }
        } catch (\Exception $e) {
            $respuestaBot = 'Error de conexión. Por favor, verifica tu internet e intenta nuevamente.';
        }
        #guardar conversacion en la bd
        if (Auth::check()) {
            ChatbotConversacion::create([
                'id_usuario' => Auth::id(),
                'mensaje_usuario' => $mensajeUsuario,
                'respuesta_bot' => $respuestaBot,
                'fecha_conversacion' => now()
            ]);
        }
        return response()->json([
            'success' => true,
            'respuesta' => $respuestaBot
        ]);
    }

    #historial
    public function obtenerHistorial()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión'
            ]);
        }
        $conversaciones = ChatbotConversacion::where('id_usuario', Auth::id())
            ->orderBy('fecha_conversacion', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'conversaciones' => $conversaciones
        ]);
    }
}