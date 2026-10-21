<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('civil_protection_cases', function (Blueprint $table) {
            $table->id();
            // Nulo mientras la solicitud en línea es borrador; se asigna al enviarla
            $table->string('folio')->nullable()->unique();
            $table->foreignId('civil_protection_procedure_id')
                ->constrained('civil_protection_procedures', 'id', 'cp_cases_procedure_fk');
            // Ciudadano vinculado (recibe los mensajes en su panel)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            // online = enviado desde el portal · presencial = carpeta creada en ventanilla
            $table->string('origin')->default('presencial');
            $table->string('person_type')->default('fisica');
            $table->string('applicant_name');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('status')->default('en_revision');
            // Fecha en que el expediente entró a revisión (envío en línea o creación en ventanilla)
            $table->timestamp('submitted_at')->nullable();

            // Entero (orden de pago) — se genera al pasar a "Entero generado"
            $table->string('payment_order_folio')->nullable()->unique();
            $table->string('payment_order_concept')->nullable();
            $table->decimal('payment_order_amount', 12, 2)->nullable();
            $table->text('payment_order_note')->nullable();
            $table->timestamp('payment_order_generated_at')->nullable();
            $table->foreignId('payment_order_generated_by')->nullable()->constrained('users')->nullOnDelete();
            // Pago — se registra al pasar a "Pago confirmado"
            $table->string('payment_receipt_name')->nullable();
            $table->text('payment_receipt_s3_url')->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamp('payment_confirmed_at')->nullable();

            // Documento emitido — número consecutivo por prefijo del trámite: TCM-138-2026
            $table->unsignedInteger('document_consecutive')->nullable();
            $table->string('document_number')->nullable()->unique();
            $table->string('document_name')->nullable();
            $table->text('document_s3_url')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_cases');
    }
};
