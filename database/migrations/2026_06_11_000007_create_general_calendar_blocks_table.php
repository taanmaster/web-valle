<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_calendar_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_calendar_procedure_id')
                ->constrained('general_calendar_procedures')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0=domingo ... 6=sábado
            $table->time('start_time'); // bloque de 30 minutos
            $table->timestamps();

            $table->unique(
                ['general_calendar_procedure_id', 'day_of_week', 'start_time'],
                'gc_blocks_procedure_day_time_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_calendar_blocks');
    }
};
