<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Talleres y pláticas de la Dirección de Medio Ambiente.
     * Tabla propia: estos eventos NO entran en la tabla `events` compartida,
     * así que nunca aparecen en el calendario de la portada municipal.
     */
    public function up(): void
    {
        Schema::create('environment_events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->datetime('date_start');
            $table->datetime('date_end')->nullable();
            $table->string('location')->nullable();
            $table->string('blog_url')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('date_start');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environment_events');
    }
};
