<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('civil_protection_procedure_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_protection_procedure_id')
                ->constrained('civil_protection_procedures', 'id', 'cp_proc_req_procedure_fk')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('name');
            $table->string('instructions')->nullable();
            $table->boolean('is_required')->default(true);
            // Formatos aceptados: ["pdf","jpg","png"]
            $table->json('formats');
            $table->boolean('requires_original')->default(false);
            // Requisito precargado en todos los trámites (Oficio de petición), no editable
            $table->boolean('is_fixed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_procedure_requirements');
    }
};
