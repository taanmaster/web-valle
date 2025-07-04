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
        Schema::create('d_i_f_prescriptions', function (Blueprint $table) {
            $table->id();

            $table->string('prescription_num')->unique();
            $table->integer('doctor_id')->unsigned();
            $table->integer('patient_id')->unsigned();

            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->date('prescription_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_prescriptions');
    }
};
