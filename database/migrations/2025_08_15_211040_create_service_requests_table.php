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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('dependency_name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->double('cost')->nullable();
            $table->string('steps_filename')->nullable();
            $table->string('procedure_filename')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
