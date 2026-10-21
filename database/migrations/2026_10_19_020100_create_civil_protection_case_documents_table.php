<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un registro por requisito del trámite; guarda una copia del requisito al momento de iniciar
        Schema::create('civil_protection_case_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_protection_case_id')
                ->constrained('civil_protection_cases', 'id', 'cp_case_docs_case_fk')->cascadeOnDelete();
            $table->foreignId('civil_protection_procedure_requirement_id')->nullable()
                ->constrained('civil_protection_procedure_requirements', 'id', 'cp_case_docs_req_fk')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('name');
            $table->string('instructions')->nullable();
            $table->boolean('is_required')->default(true);
            $table->json('formats');
            $table->boolean('requires_original')->default(false);
            // sin_entregar · por_revisar · aceptado · rechazado
            $table->string('status')->default('sin_entregar');
            $table->string('rejection_reason')->nullable();
            $table->boolean('original_received')->default(false);
            $table->boolean('added_after_start')->default(false);
            $table->timestamps();
        });

        Schema::create('civil_protection_case_document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_protection_case_document_id')
                ->constrained('civil_protection_case_documents', 'id', 'cp_doc_versions_doc_fk')->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->string('filename');
            $table->unsignedBigInteger('filesize')->nullable();
            $table->text('s3_url');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('uploaded_by_citizen')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_case_document_versions');
        Schema::dropIfExists('civil_protection_case_documents');
    }
};
