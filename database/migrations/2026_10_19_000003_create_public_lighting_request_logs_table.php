<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_lighting_request_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_lighting_request_id')->constrained('public_lighting_requests')->cascadeOnDelete();
            // Nulo cuando el registro lo genera el sistema (p. ej. recepción de la petición)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_lighting_request_logs');
    }
};
