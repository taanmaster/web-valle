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
        Schema::create('bidding_deliverables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bidding_id');
            $table->unsignedBigInteger('contract_id');

            $table->string('file_name')->nullable();
            $table->string('file')->nullable();

            $table->date('upload_date')->nullable();

            $table->date('due_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidding_deliverables');
    }
};
