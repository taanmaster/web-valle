<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('civil_protection_case_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('civil_protection_case_id')
                ->constrained('civil_protection_cases', 'id', 'cp_case_logs_case_fk')->cascadeOnDelete();
            // Nulo = Sistema
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_case_logs');
    }
};
