<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospedajes', function (Blueprint $table) {
            $table->boolean('aire_acondicionado')->default(false)->after('estacionamiento');
            $table->boolean('tv')->default(false)->after('aire_acondicionado');
        });
    }

    public function down(): void
    {
        Schema::table('hospedajes', function (Blueprint $table) {
            $table->dropColumn(['aire_acondicionado', 'tv']);
        });
    }
};