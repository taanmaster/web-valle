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
        Schema::create('backoffice_document_validations', function (Blueprint $table) {
            $table->id();
            
            // Relación con documento
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('backoffice_documents')->onDelete('cascade');
            
            // Usuario que validó (cada usuario solo puede validar una vez por documento)
            $table->unsignedBigInteger('validator_id');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
            
            // Mensaje del validador
            $table->text('message')->nullable()->comment('Mensaje opcional del validador');
            
            $table->timestamps();
            
            // Constraint único: un usuario solo puede validar una vez por documento
            $table->unique(['document_id', 'validator_id'], 'unique_document_validator');
            
            // Índices
            $table->index('document_id');
            $table->index('validator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backoffice_document_validations');
    }
};
