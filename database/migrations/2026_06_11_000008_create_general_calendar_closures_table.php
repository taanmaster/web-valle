<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_calendar_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_calendar_procedure_id')
                ->constrained('general_calendar_procedures')
                ->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_calendar_closures');
    }
};
