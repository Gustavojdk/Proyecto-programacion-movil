<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('normativas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('categoria')->nullable();
            $table->string('version')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime')->default('application/pdf');
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->boolean('activo');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['activo', 'categoria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('normativas');
    }
};
