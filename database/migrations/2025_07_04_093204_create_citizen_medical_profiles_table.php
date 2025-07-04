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
        Schema::create('citizen_medical_profiles', function (Blueprint $table) {
            $table->id();

            $table->integer('citizen_id')->unsigned()->unique();
            $table->string('medical_num');

            $table->string('blood_type')->nullable();
            $table->string('allergies')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('medications')->nullable();

            $table->string('gender');
            $table->string('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_medical_profiles');
    }
};
