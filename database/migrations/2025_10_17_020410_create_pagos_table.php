<?php
// ============================================
// MIGRACIÓN 4: create_pagos_table
// Ubicación: database/migrations/XXXX_XX_XX_XXXXXX_create_pagos_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_reserva');
            $table->decimal('monto', 10, 2);
            $table->enum('metodo', ['tarjeta', 'yape', 'plin', 'paypal', 'transferencia']);
            $table->enum('estado_pago', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->timestamp('fecha_pago')->useCurrent();
            $table->string('referencia_pago', 100)->nullable();

            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('reservas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};