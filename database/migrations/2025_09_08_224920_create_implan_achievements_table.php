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
        Schema::create('implan_achievements', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();

            $table->string('hex')->nullable();

            $table->string('image')->nullable();
            $table->string('file')->nullable();


            $table->date('published_at')->nullable();
            $table->boolean('is_active')->default(true)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implan_achievements');
    }
};
