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
        Schema::create('urban_dev_formats', function (Blueprint $table) {
            $table->id();
            // Cada solicitud sólo puede tener un formato relacionado.
            $table->foreignId('urban_dev_request_id')
                ->unique()
                ->constrained('urban_dev_requests')
                ->cascadeOnDelete();
            // Tipo de formato: uso-de-suelo | licencia-de-construccion
            $table->string('format_type');
            // Todos los campos de texto del formato se guardan como JSON.
            $table->json('data');
            // Archivos en S3
            $table->string('croquis_path')->nullable();
            $table->string('signature_applicant_path')->nullable();
            $table->string('signature_perito_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_dev_formats');
    }
};
