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
        Schema::create('backoffice_document_versions', function (Blueprint $table) {
            $table->id();
            
            // Relación con documento
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('backoffice_documents')->onDelete('cascade');
            
            // Tipo de actividad (creación, edición, validación, corrección, firma, etc.)
            $table->string('activity_type')->comment('Tipo de actividad realizada');
            
            // Detalle de la actividad
            $table->text('activity_detail')->comment('Descripción detallada de la actividad');
            
            // Campo modificado (nullable si es una acción sin modificar campos)
            $table->string('modified_field')->nullable()->comment('Campo que fue modificado');
            
            // Usuario que realizó la modificación
            $table->unsignedBigInteger('modified_by');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            
            // Snapshot del documento en ese momento (JSON)
            $table->json('snapshot')->comment('Estado completo del documento en ese momento');
            
            $table->timestamps();
            
            // Índices
            $table->index('document_id');
            $table->index('modified_by');
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backoffice_document_versions');
    }
};
