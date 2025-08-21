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
        Schema::create('d_i_f_socio_economic_test_dependents', function (Blueprint $table) {
            $table->id();

            $table->integer('socio_economic_test_id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('relationship')->nullable();
            $table->string('schooling')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('weekly_income')->nullable();
            $table->string('monthly_income')->nullable();
            $table->string('occupation')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_socio_economic_test_dependents');
    }
};
