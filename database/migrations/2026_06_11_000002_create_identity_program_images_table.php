<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identity_program_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identity_program_id')
                ->constrained('identity_programs')
                ->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identity_program_images');
    }
};
