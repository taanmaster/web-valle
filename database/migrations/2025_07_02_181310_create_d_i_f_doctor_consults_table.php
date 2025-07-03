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
        Schema::create('d_i_f_doctor_consults', function (Blueprint $table) {
            $table->id();

            $table->integer('doctor_id')->unsigned();
            $table->integer('patient_id')->unsigned();

            $table->string('consult_num')->unique();
            $table->date('consult_date')->nullable();
            $table->text('consult_description')->nullable();
            $table->integer('consult_type_id')->unsigned()->nullable();
            $table->string('status')->default('completed'); // pending, completed, cancelled

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_doctor_consults');
    }
};
