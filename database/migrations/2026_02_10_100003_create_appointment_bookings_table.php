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
        Schema::create('appointment_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique()->comment('Folio único de la cita');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date')->comment('Fecha de la cita');
            $table->time('start_time')->comment('Hora de inicio de la cita');
            $table->time('end_time')->comment('Hora de fin de la cita');
            $table->string('status')->default('scheduled')->comment('scheduled, confirmed, cancelled');
            $table->string('attendance_status')->nullable()->comment('pending, attended, not_attended');
            $table->string('full_name')->comment('Nombre completo del ciudadano');
            $table->string('email')->comment('Correo electrónico');
            $table->string('phone')->comment('Teléfono de contacto');
            $table->text('notes')->nullable()->comment('Notas adicionales');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Garantizar 1 cita por slot (excluir canceladas se valida en código)
            $table->unique(['appointment_id', 'date', 'start_time'], 'unique_appointment_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_bookings');
    }
};
