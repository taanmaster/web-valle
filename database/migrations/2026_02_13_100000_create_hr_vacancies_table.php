<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('active');
            $table->dateTime('published_at')->nullable();
            $table->string('position_name');
            $table->string('dependency')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('work_schedule')->nullable();
            $table->string('location')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->dateTime('closing_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_vacancies');
    }
};
