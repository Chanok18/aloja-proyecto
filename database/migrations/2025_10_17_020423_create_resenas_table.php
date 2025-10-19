<?php
// ============================================
// MIGRACIÓN 5: create_resenas_table
// Ubicación: database/migrations/XXXX_XX_XX_XXXXXX_create_resenas_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id('id_resena');
            $table->unsignedBigInteger('id_reserva');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_hospedaje');
            $table->integer('calificacion')->unsigned();
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_resena')->useCurrent();

            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('reservas')
                  ->onDelete('cascade');

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('id_hospedaje')
                  ->references('id_hospedaje')
                  ->on('hospedajes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
