<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hr_vacancy_id')->constrained('hr_vacancies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('cv_path')->nullable();
            $table->longText('observations')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'hr_vacancy_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_applications');
    }
};
