<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            // Flujo editorial del catálogo
            $table->string('status')->default('borrador')->index()->after('id');

            // A. Datos generales de control administrativo
            $table->string('admin_unit')->nullable();
            $table->string('receiving_area')->nullable();
            $table->string('resolving_area')->nullable();
            $table->string('issuing_authority')->nullable();
            $table->string('applying_authority')->nullable();
            $table->string('liaison_name')->nullable();
            $table->string('liaison_position')->nullable();
            $table->string('liaison_email')->nullable();
            $table->string('liaison_phone')->nullable();
            $table->date('elaboration_date')->nullable();

            // B. Identificación del trámite o servicio
            $table->string('homoclave')->nullable()->index();
            $table->string('type')->nullable();
            $table->string('responsible_subject')->nullable();
            $table->json('modalities')->nullable();

            // C. Canal de atención y disponibilidad
            $table->json('channels')->nullable();
            $table->boolean('can_start_online')->nullable();
            $table->boolean('can_finish_online')->nullable();
            $table->string('online_url')->nullable();

            // E. Fundamento jurídico y regulación
            $table->text('legal_basis')->nullable();
            $table->string('regulation_name')->nullable();
            $table->string('regulation_media')->nullable();
            $table->date('regulation_publication_date')->nullable();
            $table->string('regulation_articles')->nullable();

            // G. Presentación y formato de la solicitud
            $table->json('submission_forms')->nullable();
            $table->string('format_name')->nullable();
            $table->string('format_media')->nullable();
            $table->date('format_publication_date')->nullable();
            $table->string('format_filename')->nullable();

            // H. Inspección o verificación
            $table->boolean('requires_inspection')->nullable();
            $table->string('inspection_objective')->nullable();
            $table->string('inspection_authority')->nullable();
            $table->string('inspection_moment')->nullable();
            $table->string('inspection_legal_basis')->nullable();
            $table->text('inspection_criteria')->nullable();

            // I. Contacto, oficinas y horarios de atención
            $table->string('contact_area')->nullable();
            $table->string('contact_advisor')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_media')->nullable();
            $table->text('reception_address')->nullable();
            $table->boolean('has_alternate_office')->nullable();
            $table->string('alternate_office_url')->nullable();
            $table->string('schedule_days')->nullable();
            $table->string('schedule_reception')->nullable();
            $table->string('schedule_resolution')->nullable();
            $table->string('non_working_days')->nullable();

            // J. Plazos de resolución y prevención
            $table->string('resolution_time')->nullable();
            $table->string('resolution_time_unit')->nullable();
            $table->string('resolution_legal_basis')->nullable();
            $table->boolean('afirmativa_ficta')->nullable();
            $table->boolean('negativa_ficta')->nullable();
            $table->string('ficta_legal_basis')->nullable();
            $table->string('prevention_time')->nullable();
            $table->string('compliance_time')->nullable();
            $table->string('prevention_media')->nullable();
            $table->string('prevention_legal_basis')->nullable();

            // K. Costos, derechos y formas de pago
            $table->string('applicable_amount')->nullable();
            $table->string('fee_legal_basis')->nullable();
            $table->string('variable_fee_method')->nullable();
            $table->json('payment_options')->nullable();

            // L. Vigencia, criterios de resolución y frecuencia
            $table->string('validity')->nullable();
            $table->string('validity_legal_basis')->nullable();
            $table->boolean('allows_renewal')->nullable();
            $table->text('resolution_criteria')->nullable();
            $table->string('annual_requests')->nullable();
            $table->string('reported_period')->nullable();
            $table->string('information_source')->nullable();
            $table->text('frequency_observations')->nullable();

            // M. Información al solicitante, sanciones y privacidad
            $table->text('applicant_records')->nullable();
            $table->string('sanction_conduct')->nullable();
            $table->string('sanction_applicable')->nullable();
            $table->string('sanction_legal_basis')->nullable();
            $table->boolean('collects_personal_data')->nullable();
            $table->string('personal_data_types')->nullable();
            $table->string('privacy_notice_name')->nullable();
            $table->string('privacy_notice_url')->nullable();
        });

        // Los registros existentes ya son visibles en el portal ciudadano
        DB::table('service_requests')->update(['status' => 'publicado']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'admin_unit', 'receiving_area', 'resolving_area', 'issuing_authority',
                'applying_authority', 'liaison_name', 'liaison_position', 'liaison_email',
                'liaison_phone', 'elaboration_date',
                'homoclave', 'type', 'responsible_subject', 'modalities',
                'channels', 'can_start_online', 'can_finish_online', 'online_url',
                'legal_basis', 'regulation_name', 'regulation_media',
                'regulation_publication_date', 'regulation_articles',
                'submission_forms', 'format_name', 'format_media',
                'format_publication_date', 'format_filename',
                'requires_inspection', 'inspection_objective', 'inspection_authority',
                'inspection_moment', 'inspection_legal_basis', 'inspection_criteria',
                'contact_area', 'contact_advisor', 'contact_phone', 'contact_email',
                'contact_media', 'reception_address', 'has_alternate_office',
                'alternate_office_url', 'schedule_days', 'schedule_reception',
                'schedule_resolution', 'non_working_days',
                'resolution_time', 'resolution_time_unit', 'resolution_legal_basis',
                'afirmativa_ficta', 'negativa_ficta', 'ficta_legal_basis',
                'prevention_time', 'compliance_time', 'prevention_media',
                'prevention_legal_basis',
                'applicable_amount', 'fee_legal_basis', 'variable_fee_method',
                'payment_options',
                'validity', 'validity_legal_basis', 'allows_renewal',
                'resolution_criteria', 'annual_requests', 'reported_period',
                'information_source', 'frequency_observations',
                'applicant_records', 'sanction_conduct', 'sanction_applicable',
                'sanction_legal_basis', 'collects_personal_data', 'personal_data_types',
                'privacy_notice_name', 'privacy_notice_url',
            ]);
        });
    }
};
