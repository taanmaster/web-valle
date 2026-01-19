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
        Schema::create('backoffice_documents', function (Blueprint $table) {
            $table->id();
            
            // Folio único autogenerado (formato: CODE-DDMMYY-CONSECUTIVO)
            $table->string('folio')->unique()->comment('Folio único del oficio');
            
            // Relaciones
            $table->unsignedBigInteger('dependency_id');
            $table->foreign('dependency_id')->references('id')->on('backoffice_dependencies')->onDelete('cascade');
            
            $table->unsignedBigInteger('user_id')->comment('Usuario creador del oficio');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Datos del oficio
            $table->date('issue_date')->comment('Fecha de expedición');
            $table->string('subject')->comment('Asunto del oficio');
            $table->string('sender')->comment('Remitente (auto del responsible_name de dependencia)');
            $table->longText('body')->comment('Cuerpo del oficio');
            $table->string('requester')->comment('Solicitante');
            
            // Selectores
            $table->enum('priority', ['urgente', 'alta', 'baja'])->default('baja')->comment('Prioridad del oficio');
            $table->enum('type', ['solicitud', 'respuesta'])->default('solicitud')->comment('Tipo de oficio');
            $table->enum('status', ['borrador', 'revision', 'validado', 'firmado'])->default('borrador')->comment('Estado del oficio');
            
            // Firma y sello (almacenados en S3)
            $table->string('signature_filename')->nullable();
            $table->string('signature_s3_url')->nullable();
            $table->string('stamp_filename')->nullable();
            $table->string('stamp_s3_url')->nullable();
            
            // Control de validaciones (necesita 3 para poder firmar)
            $table->unsignedTinyInteger('validations_count')->default(0)->comment('Contador de validaciones (máx 3)');
            
            // Control de primera lectura del colaborador asignado
            $table->timestamp('first_read_at')->nullable()->comment('Fecha de primera lectura');
            
            // Colaborador asignado para revisión
            $table->unsignedBigInteger('assigned_to')->nullable()->comment('Usuario asignado para revisión');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->text('assignment_message')->nullable()->comment('Mensaje enviado al colaborador');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('dependency_id');
            $table->index('user_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index('priority');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backoffice_documents');
    }
};
