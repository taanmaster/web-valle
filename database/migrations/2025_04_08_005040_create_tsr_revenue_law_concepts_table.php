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
        Schema::create('tsr_revenue_law_concepts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('income_id')->unsigned();

            $table->string('CRI');
            $table->string('concept');
            $table->string('estimated_income')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_revenue_law_concepts');
    }
};
