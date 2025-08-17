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
        Schema::create('municipal_regulations', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('regulation_type')->nullable();
            $table->string('publication_type')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('file')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('word_file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipal_regulations');
    }
};
