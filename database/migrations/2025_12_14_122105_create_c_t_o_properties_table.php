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
        Schema::create('c_t_o_properties', function (Blueprint $table) {
            $table->id();

            // Taxpayer information
            $table->string('taxpayer_type')->nullable();
            $table->string('taxpayer_name')->nullable();
            $table->string('taxpayer_phone')->nullable();
            
            // Address information
            $table->string('street');
            $table->string('street_num');
            $table->string('int_num')->nullable();
            $table->string('suburb');
            
            // Cuota information
            $table->string('cuota_type')->nullable();
            
            // Location information
            $table->string('location_account')->nullable();
            $table->string('location_type')->nullable();
            $table->string('location_num')->nullable();
            $table->text('location_note')->nullable();
            $table->string('location_origin')->nullable();
            $table->decimal('location_surface', 12, 2)->nullable();
            $table->string('location_use')->nullable();
            $table->decimal('location_law_value', 15, 2)->nullable();
            $table->decimal('location_surface_built', 12, 2)->nullable();
            $table->string('location_condition')->nullable();
            
            // Appraisal and payment information
            $table->date('last_appraisal')->nullable();
            $table->decimal('payment_anual', 15, 2)->nullable();
            $table->decimal('payment_bimonthly', 15, 2)->nullable();
            $table->decimal('tax_rate', 8, 4)->nullable();
            $table->decimal('total_payment', 15, 2)->nullable();
            
            // Date information
            $table->date('issue_date')->nullable();
            $table->date('validity_date')->nullable();
            $table->date('payment_date')->nullable();
            
            // JSON and additional fields
            $table->json('bank_reference_json')->nullable();
            $table->text('notification_address')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_t_o_properties');
    }
};
