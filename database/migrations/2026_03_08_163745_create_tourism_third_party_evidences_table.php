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
        Schema::create('tourism_third_party_evidences', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('tourism_third_party_request_id')->constrained('tourism_third_party_requests')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('file_path');
            $table->string('file_extension', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_third_party_evidences');
    }
};
