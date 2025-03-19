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
        Schema::create('treasury_account_payable_contractor_checklists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('contractor_id')->unsigned(); // ID del contratista
            $table->bigInteger('checklist_id')->unsigned(); // ID del checklist

            $table->string('folio')->nullable(); // Folio
            $table->date('received_at')->nullable(); // Fecha de recepción

            $table->string('program_code')->nullable(); // Código de programa
            $table->string('program_name')->nullable(); // Nombre del programa
            $table->string('funding_source')->nullable(); // Fuente del financiamiento
            $table->string('budget_item')->nullable(); // Partida
            $table->string('work_number')->nullable(); // No. de obra
            $table->string('reserve_doc_pres')->nullable(); // Reserva, doc pres
            $table->string('fixed_asset_number')->nullable(); // No. de activo fijo
            $table->string('contract_number')->nullable(); // Contrato No
            $table->string('contractor')->nullable(); // Contratista
            $table->string('taxpayer_registration')->nullable(); // Registro federal de contribuyente
            $table->string('award_method')->nullable(); // Modalidad de adjudicación
            $table->boolean('with_resources')->nullable(); // Con recursos
            $table->string('agreement')->nullable(); // Convenio
            $table->string('execution_annex')->nullable(); // Anexo de ejecución
            $table->string('work')->nullable(); // Obra
            $table->decimal('contract_amount', 15, 2)->nullable(); // Importe del contrato
            $table->decimal('advance_amount', 15, 2)->nullable(); // Monto del anticipo
            $table->date('contract_signing_date')->nullable(); // Fecha de firma del contrato
            $table->date('contract_validity_start')->nullable(); // Vigencia contrato - inicia
            $table->date('contract_validity_end')->nullable(); // Vigencia contrato - termina
            $table->date('validity_modification_start')->nullable(); // Modificación de la vigencia - inicia
            $table->date('validity_modification_end')->nullable(); // Modificación de la vigencia - termina
            $table->decimal('modification_agreement_amount', 15, 2)->nullable(); // Convenio modificatorio en monto
            $table->decimal('amount', 15, 2)->nullable(); // Importe
            $table->date('modification_agreement_time_start')->nullable(); // Convenio modificatorio en tiempo - inicia
            $table->date('modification_agreement_time_end')->nullable(); // Convenio modificatorio en tiempo - termina
            $table->decimal('estimated', 15, 2)->nullable(); // Estimado
            $table->decimal('iva', 15, 2)->nullable(); // IVA
            $table->decimal('sum', 15, 2)->nullable(); // Suma
            $table->decimal('advance_amortization', 15, 2)->nullable(); // Amortización del anticipo
            $table->decimal('subtotal', 15, 2)->nullable(); // Subtotal
            $table->decimal('penalty', 15, 2)->nullable(); // Sanción
            $table->decimal('net_scope', 15, 2)->nullable(); // Alcance neto
            $table->decimal('subtotal_2', 15, 2)->nullable(); // Subtotal 2
            $table->decimal('iva_2', 15, 2)->nullable(); // IVA 2
            $table->decimal('total', 15, 2)->nullable(); // Total
            $table->decimal('faism_2024_pays', 15, 2)->nullable(); // FAISM 2024 paga
            $table->decimal('state_pays', 15, 2)->nullable(); // Estado paga
            $table->string('prepared_by')->nullable(); // Elaborado por

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_account_payable_contractor_checklists');
    }
};