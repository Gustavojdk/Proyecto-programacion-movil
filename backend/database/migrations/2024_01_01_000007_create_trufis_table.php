<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trufis', function (Blueprint $table) {
            $table->id('idtrufi');
            $table->string('nom_linea');
            $table->decimal('costo', 8, 2);
            $table->string('frecuencia');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->boolean('estado');
            $table->foreignId('sindicato_id')->nullable()->constrained('sindicatos')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trufis');
    }
};
