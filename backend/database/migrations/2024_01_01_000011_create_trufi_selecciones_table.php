<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trufi_selecciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idtrufi');
            $table->string('device_id')->nullable()->index();
            $table->string('source')->default('flutter')->index();
            $table->timestamps();

            $table->foreign('idtrufi')->references('idtrufi')->on('trufis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trufi_selecciones');
    }
};
