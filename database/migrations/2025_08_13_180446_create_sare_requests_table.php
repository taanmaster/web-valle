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
        Schema::create('sare_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('status')->default('new'); // Options: new, in_progress, cancelled, payment_pending, authorized, rejected, validation
            $table->string('request_type')->default('general');
            $table->text('description')->nullable();

            // General Info
            $table->string('request_num');
            $table->string('request_date');
            $table->string('catastral_num');

            // Datos del Solicitante
            $table->string('rfc_name');
            $table->string('rfc_num');
            $table->string('property_owner');
            $table->string('office_phone');
            $table->string('mobile_phone');
            $table->string('email');

            // Representante Legal
            $table->string('legal_representative_name');
            $table->string('legal_representative_father_last_name');
            $table->string('legal_representative_mother_last_name');
            $table->string('legal_representative_office_phone');
            $table->string('legal_representative_mobile_phone');
            $table->string('legal_representative_personal_phone');
            $table->string('legal_representative_email');
            $table->string('legal_representative_ownership_document'); // Options: Apoderado Especial, Apoderado General, Gestor de Trámite, Poder Notariado, Escritura Pública, Poder Simple

            // Responsable del Establecimiento
            $table->string('establishment_legal_cause'); // Options: Proprietario, Arrendatario, Otro
            $table->string('establishment_legal_cause_addon')->nullable();
            $table->string('establishment_good_faith_clause'); // Options: Si, No, N/A

            // Domicilio del Establecimiento
            $table->string('establishment_address_street');
            $table->string('establishment_address_number');
            $table->string('establishment_address_neighborhood');
            $table->string('establishment_address_municipality');
            $table->string('establishment_address_state');
            $table->string('establishment_address_postal_code');

            // Datos del uso de la edificación
            $table->string('establishment_use')->nullable();
            $table->string('commercial_name');
            $table->string('aprox_investment');
            $table->string('jobs_to_generate');
            $table->boolean('is_location_in_operation')->default(true);
            $table->string('operation_start_date')->nullable(); // Fecha de inicio de operaciones
            $table->string('business_hours')->nullable();

            // Zoning
            $table->string('zoning_front')->nullable();
            $table->string('zoning_rear')->nullable();
            $table->string('zoning_left')->nullable();
            $table->string('zoning_right')->nullable();

            // Para Llenado Exlusivo de Municipio
            $table->string('license_num')->nullable();
            $table->boolean('vobo_favorable')->default(false);
            $table->datetime('entry_date')->nullable(); // Fecha de ingreso
            $table->datetime('exit_date')->nullable(); // Fecha de Resolución
            $table->string('document_type')->nullable(); // Options: Permiso nuevo, Renovación, Anuncio

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sare_requests');
    }
};
