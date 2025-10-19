<?php
// ============================================
// MIGRACIÓN 6: create_chatbot_conversaciones_table
// Ubicación: database/migrations/XXXX_XX_XX_XXXXXX_create_chatbot_conversaciones_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_conversaciones', function (Blueprint $table) {
            $table->id('id_conversacion');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->text('mensaje_usuario');
            $table->text('respuesta_bot');
            $table->timestamp('fecha_mensaje')->useCurrent();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_conversaciones');
    }
};