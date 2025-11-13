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
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();

            $table->string('status')->nullable();

            $table->string('dependency_name')->nullable();
            $table->decimal('ammount', 15, 2)->nullable();
            $table->string('service')->nullable();

            $table->text('justification')->nullable();

            $table->string('requirement_file')->nullable();
            $table->string('request_file')->nullable();

            $table->string('bidding_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biddings');
    }
};
