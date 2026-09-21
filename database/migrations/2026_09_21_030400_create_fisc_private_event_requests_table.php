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
        Schema::create('fisc_private_event_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('folio')->nullable();
            $table->string('status')->default('nueva_solicitud');

            // Datos del evento
            $table->string('event_type');
            $table->date('event_date');
            $table->string('responsible_person');
            $table->string('schedule');
            $table->string('venue');
            $table->integer('attendees')->nullable();
            $table->boolean('alcohol_sales')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisc_private_event_requests');
    }
};
