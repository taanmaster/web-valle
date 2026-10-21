<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('civil_protection_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_protection_case_id')
                ->constrained('civil_protection_cases', 'id', 'cp_inspections_case_fk')->cascadeOnDelete();
            $table->foreignId('inspector_id')->constrained('users');
            $table->foreignId('scheduled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('scheduled_at');
            $table->text('note_to_citizen')->nullable();
            // pendiente · sin_observaciones · con_observaciones · no_procede · no_realizada
            $table->string('result')->default('pendiente');
            $table->date('visit_date')->nullable();
            $table->text('observations')->nullable();
            $table->json('photos')->nullable();
            $table->string('act_name')->nullable();
            $table->text('act_s3_url')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_inspections');
    }
};
