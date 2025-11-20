<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidding_proposals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bidding_id');
            $table->unsignedBigInteger('supplier_id');

            $table->string('file_name')->nullable();
            $table->string('file')->nullable();

            $table->string('status')->nullable();
            $table->date('status_update')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidding_proposals');
    }
};
