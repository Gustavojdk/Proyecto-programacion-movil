<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sindicato_radiotaxi_paradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sindicato_radiotaxi_id')->unique()->constrained('sindicato_radiotaxis')->onDelete('cascade');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->text('descripcion')->nullable();
            $table->string('direccion')->nullable();
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sindicato_radiotaxi_paradas');
    }
};
