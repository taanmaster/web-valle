<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_lighting_request_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_lighting_request_id')->constrained('public_lighting_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // citizen = evidencia del problema · attention = evidencia de atención (personal)
            $table->string('type')->default('citizen');
            $table->string('name')->nullable();
            $table->string('filename');
            $table->string('file_extension', 20)->nullable();
            $table->unsignedBigInteger('filesize')->nullable();
            $table->text('s3_asset_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_lighting_request_files');
    }
};
