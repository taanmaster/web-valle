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
        Schema::create('service_request_related_procedures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_request_id');
            $table->string('name')->nullable();
            $table->string('homoclave')->nullable();
            $table->string('subject_level')->nullable();
            $table->string('relation_type')->nullable();

            $table->timestamps();

            $table->foreign('service_request_id')
                ->references('id')->on('service_requests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_related_procedures');
    }
};
