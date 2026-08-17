<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bitácora interna de una solicitud de Medio Ambiente.
     */
    public function up(): void
    {
        Schema::create('environment_request_notes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('environment_request_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('note');

            $table->timestamps();

            $table->index('environment_request_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environment_request_notes');
    }
};
