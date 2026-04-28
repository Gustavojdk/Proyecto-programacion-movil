<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trufi_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trufi_id')->unique();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->timestamps();

            $table->foreign('trufi_id')->references('idtrufi')->on('trufis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trufi_detalles');
    }
};
