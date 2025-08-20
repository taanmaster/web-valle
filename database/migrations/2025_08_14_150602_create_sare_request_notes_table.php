<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // La base de datos de Notas para las solicitudes SARE funciona como un sistema de mensajería entre el ciudadano y el equipo administrativo SARE.
        Schema::create('sare_request_notes', function (Blueprint $table) {
            $table->id();

            $table->integer('sare_request_id')->unsigned()->index();
            $table->integer('user_id')->unsigned(); // Autor de la nota.
            $table->string('user_role')->nullable(); // Este es para identificar si el mensaje es de un ciudadano o un usuario administrativo.

            $table->text('note');
            $table->string('status');
            $table->boolean('is_resolved')->default(false);
            $table->boolean('read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sare_request_notes');
    }
};
