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
        Schema::create('financial_support_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('monthly_cap');
            $table->string('limit_per_citizen')->nullable();

            $table->boolean('doc_birth_certificate')->default(false);
            $table->boolean('doc_ine')->default(false);
            $table->boolean('doc_address_proof')->default(false);
            $table->boolean('doc_rfc')->default(false);
            $table->boolean('doc_death_certificate')->default(false);
            $table->boolean('doc_funeral_payment')->default(false);
            $table->boolean('doc_cemetery_docs')->default(false);
            $table->boolean('doc_study_certificate')->default(false);
            $table->boolean('doc_medical_prescriptions')->default(false);
            $table->boolean('doc_medical_certificate')->default(false);
            $table->boolean('doc_hospital_visit_card')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_support_types');
    }
};
