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
        Schema::create('tsr_admin_revenue_colletion_clauses', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('fraction_id')->unsigned();

            $table->string('clause');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('units')->nullable();
            $table->string('quote')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_admin_revenue_colletion_clauses');
    }
};
