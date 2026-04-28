<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trufi_rutas', function (Blueprint $table) {
            $table->unsignedBigInteger('idtrufi');
            $table->unsignedInteger('orden');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->boolean('puntos');
            $table->boolean('es_parada');
            $table->boolean('estado');
            $table->timestamps();

            $table->primary(['idtrufi', 'orden']);
            $table->foreign('idtrufi')->references('idtrufi')->on('trufis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trufi_rutas');
    }
};
