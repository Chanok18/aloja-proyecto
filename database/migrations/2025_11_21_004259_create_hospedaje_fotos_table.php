<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospedaje_fotos', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('id_hospedaje');
            $table->string('ruta_foto'); // Ruta de la imagen
            $table->boolean('es_principal')->default(false); // Si es la foto principal
            $table->integer('orden')->default(0); // Orden de visualización
            $table->timestamps();

            // Relación con hospedajes
            $table->foreign('id_hospedaje')
                  ->references('id_hospedaje')
                  ->on('hospedajes')
                  ->onDelete('cascade'); // Si se elimina hospedaje, se eliminan sus fotos
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospedaje_fotos');
    }
};