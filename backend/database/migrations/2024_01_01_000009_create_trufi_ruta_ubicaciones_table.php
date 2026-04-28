<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trufi_ruta_ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idtrufi');
            $table->unsignedInteger('orden');
            $table->string('nombre_via');
            $table->string('interseccion')->nullable();
            $table->string('tipo_via')->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->json('meta')->nullable();
            $table->boolean('estado');
            $table->timestamps();

            $table->unique(['idtrufi', 'orden']);
            $table->foreign('idtrufi')->references('idtrufi')->on('trufis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trufi_ruta_ubicaciones');
    }
};
