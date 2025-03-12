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
        Schema::create('headerbands', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('text');
            $table->string('button_text')->nullable();
            $table->string('band_link')->nullable();
            $table->string('priority')->nullable();
            $table->string('hex_text')->nullable();
            $table->string('hex_button_back')->nullable();
            $table->string('hex_button_text')->nullable();
            $table->string('hex_background')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headerbands');
    }
};
