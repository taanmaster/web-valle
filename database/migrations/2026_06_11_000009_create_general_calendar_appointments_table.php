<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_calendar_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('general_calendar_procedure_id');
            // Nombre explícito: el autogenerado excede los 64 caracteres de MySQL
            $table->foreign('general_calendar_procedure_id', 'gc_appointments_procedure_fk')
                ->references('id')->on('general_calendar_procedures')
                ->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('approval_id')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamps();

            $table->index(['general_calendar_procedure_id', 'date'], 'gc_appointments_procedure_date_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_calendar_appointments');
    }
};
