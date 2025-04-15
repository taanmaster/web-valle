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
        Schema::create('regulatory_agenda_regulations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('dependency_id')->unsigned();

            $table->string('name');
            $table->string('subject')->nullable();
            $table->text('problematic')->nullable();
            $table->text('justification')->nullable();
            $table->date('presentation_date')->nullable(); // Fecha de presentación
            $table->string('type')->nullable();
            $table->string('impact')->nullable();
            $table->string('beneficiaries')->nullable();
            $table->string('semester')->nullable();
            $table->boolean('is_active')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulatory_agenda_regulations');
    }
};
