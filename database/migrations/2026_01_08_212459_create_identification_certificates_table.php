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
        Schema::create('identification_certificates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('certificate_type');
            $table->string('folio', 10)->unique();
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('curp', 18);
            $table->text('address');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('Solicitud nueva');

            $table->string('birth_certificate_file')->nullable();
            $table->boolean('birth_certificate_approved')->default(false);
            $table->string('proof_of_address_file')->nullable();
            $table->boolean('proof_of_address_approved')->default(false);
            $table->string('photo_file')->nullable();
            $table->boolean('photo_approved')->default(false);

            $table->string('first_witness_full_name')->nullable();
            $table->date('first_witness_birth_date')->nullable();
            $table->text('first_witness_address')->nullable();
            $table->string('first_witness_ine_file')->nullable();
            $table->boolean('first_witness_ine_approved')->default(false);

            $table->string('second_witness_full_name')->nullable();
            $table->date('second_witness_birth_date')->nullable();
            $table->text('second_witness_address')->nullable();
            $table->string('second_witness_ine_file')->nullable();
            $table->boolean('second_witness_ine_approved')->default(false);

            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identification_certificates');
    }
};
