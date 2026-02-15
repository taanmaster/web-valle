<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tourism_third_party_requests', function (Blueprint $table) {
            $table->id();

            // Sistema
            $table->string('folio')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('Enviada');

            // Sección 1: Solicitante
            $table->string('full_name');
            $table->string('organization_name')->nullable();
            $table->string('applicant_type'); // persona_fisica / persona_moral
            $table->string('rfc_or_curp');
            $table->string('fiscal_address');
            $table->string('phone');
            $table->string('email');

            // Sección 2: Evento
            $table->string('event_name');
            $table->string('event_type');
            $table->longText('event_objective');
            $table->longText('event_description');

            // Sección 3: Fecha y Lugar
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue');
            $table->string('event_access_type');

            // Sección 4: Impacto
            $table->string('expected_impact');
            $table->integer('estimated_attendees');
            $table->longText('promotes_identity');
            $table->longText('generates_economic_impact');

            // Sección 5: Apoyo Solicitado
            $table->string('support_type');
            $table->longText('support_description');

            // Sección 6: Declaración / Firma
            $table->string('signature_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_third_party_requests');
    }
};
