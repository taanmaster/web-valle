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
        Schema::create('tsr_revenue_law_rate_and_fees', function (Blueprint $table) {
            $table->id();

            $table->string('section');
            $table->string('order_number');
            $table->string('type');
            $table->text('description')->nullable();
            $table->text('concept')->nullable();
            $table->string('cost')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_revenue_law_rate_and_fees');
    }
};
