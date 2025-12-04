<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotConversacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:500'
        ]);

        $mensajeUsuario = $request->mensaje;

        // Contexto de Aloja
        $contextoAloja = "Eres Alojita, el asistente virtual amigable de Aloja.pe, una plataforma de reservas de hospedajes en Perú similar a Airbnb. 

Información clave de Aloja:
- Plataforma para buscar y reservar hospedajes seguros en todo Perú
- Métodos de pago: Yape, Plin, Tarjeta, PayPal, Transferencia
- Los anfitriones pueden publicar sus propiedades verificadas
- Los viajeros pueden buscar por ubicación, precio, capacidad y amenidades
- Sistema de reseñas y calificaciones de 5 estrellas
- Reservas instantáneas con confirmación automática
- Cancelación flexible hasta 24 horas antes del check-in
- Soporte 24/7 por chat, teléfono y correo
- Todas las propiedades son verificadas por seguridad

Responde de manera amigable, concisa (máximo 3 líneas) y útil. Si no sabes algo específico, sé honesto pero ofrece alternativas de ayuda.";

        $respuestaBot = null;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->timeout(10)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
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
                $respuestaBot = $data['choices'][0]['message']['content'] ?? null;
            }
        } catch (\Exception $e) {
            Log::warning('Groq API falló: ' . $e->getMessage());
        }

        // Si Groq falla, usar fallback
        if (!$respuestaBot) {
            $respuestaBot = $this->obtenerRespuestaFallback($mensajeUsuario);
        }

        // Guardar en BD
        if (Auth::check()) {
            try {
                ChatbotConversacion::create([
                    'id_usuario' => Auth::id(),
                    'mensaje_usuario' => $mensajeUsuario,
                    'respuesta_bot' => $respuestaBot,
                    'fecha_mensaje' => now()
                ]);
            } catch (\Exception $e) {
                Log::warning('Error guardando conversación: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'respuesta' => $respuestaBot
        ]);
    }

    private function obtenerRespuestaFallback($mensaje)
    {
        $mensajeLower = strtolower($mensaje);

        $patrones = [
            'reserva|reservar|booking' => "Para reservar, busca el hospedaje que te guste, selecciona tus fechas y número de huéspedes, y presiona 'Reservar ahora'. ¡Es instantáneo! 📅",
            
            'pago|pagar|precio|costo|tarjeta|yape|plin' => "Aceptamos Yape, Plin, Tarjeta, PayPal y Transferencia. El pago es seguro y solo se procesa después de confirmar tu reserva. 💳",
            
            'cancelar|cancelación|reembolso' => "Puedes cancelar tu reserva hasta 24 horas antes del check-in y recibir reembolso completo. Después de ese tiempo, se aplican cargos. 🔄",
            
            'buscar|encontrar|hospedaje|hotel|casa' => "Usa nuestro buscador en el inicio para filtrar por ubicación, precio, capacidad y amenidades. ¡Tenemos opciones en todo Perú! 🏠",
            
            'anfitrión|publicar|alojar' => "Si quieres convertirte en anfitrión y publicar tu propiedad, regístrate y ve a tu panel. Es gratis publicar y muy fácil. 🏘️",
            
            'ayuda|soporte|contacto|problema' => "Estoy aquí para ayudarte 24/7. También puedes contactar a soporte en contacto@aloja.pe o llamar al +51 1 234 5678. 📞",
            
            'segur|verific|confian' => "Todas nuestras propiedades son verificadas. Los anfitriones pasan por un proceso de validación y las reseñas son de usuarios reales. 🛡️",
            
            'ubicación|dónde|lugar|ciudad' => "Tenemos hospedajes en Lima, Cusco, Arequipa, Miraflores, Barranco y muchos destinos más por todo Perú. ¿Buscas algo específico? 📍",
            
            'cuenta|registr|login|sesión' => "Puedes registrarte gratis en 'Registrarse' o iniciar sesión si ya tienes cuenta. Solo toma un minuto y es totalmente seguro. 👤",
            
            'calificación|reseña|opinión|estrella' => "Nuestro sistema de reseñas permite a los viajeros calificar su experiencia del 1 al 5 estrellas. Así ayudas a otros viajeros a elegir. ⭐",
        ];

        foreach ($patrones as $patron => $respuesta) {
            if (preg_match("/($patron)/i", $mensajeLower)) {
                return $respuesta;
            }
        }

        if (preg_match('/(hola|hi|hey|buenas|buenos|saludos)/i', $mensajeLower)) {
            return "¡Hola! 👋 Soy Alojita, tu asistente de Aloja.pe. ¿En qué puedo ayudarte hoy? Pregúntame sobre reservas, pagos, cancelaciones o lo que necesites. 😊";
        }

        if (preg_match('/(chau|adiós|adios|gracias|bye|nos vemos)/i', $mensajeLower)) {
            return "¡Fue un placer ayudarte! Si tienes más preguntas, aquí estaré. ¡Que tengas un excelente día! 🌟";
        }

        return "Puedo ayudarte con reservas, pagos, cancelaciones, búsqueda de hospedajes y más. ¿Qué necesitas saber sobre Aloja? También puedes contactar a soporte: contacto@aloja.pe 😊";
    }

    public function obtenerHistorial()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión'
            ]);
        }

        try {
            $conversaciones = ChatbotConversacion::where('id_usuario', Auth::id())
                ->orderBy('fecha_mensaje', 'desc')
                ->take(10)
                ->get();

            return response()->json([
                'success' => true,
                'conversaciones' => $conversaciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener historial'
            ]);
        }
    }
}