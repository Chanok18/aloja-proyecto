<?php
// ============================================
// MIGRACIÓN 2: create_hospedajes_table
// Ubicación: database/migrations/XXXX_XX_XX_XXXXXX_create_hospedajes_table.php
// ============================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospedajes', function (Blueprint $table) {
            $table->id('id_hospedaje');
            $table->unsignedBigInteger('id_anfitrion');
            $table->string('titulo', 150);
            $table->string('ubicacion', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('capacidad');
            $table->text('fotos')->nullable();
            $table->boolean('disponible')->default(true);
            $table->boolean('wifi')->default(false);
            $table->boolean('cocina')->default(false);
            $table->boolean('estacionamiento')->default(false);
            $table->timestamps();

            $table->foreign('id_anfitrion')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospedajes');
    }
};
