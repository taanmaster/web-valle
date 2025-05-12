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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content_1')->nullable();
            $table->text('content_2')->nullable();
            $table->string('hero_img')->nullable();
            $table->string('category');
            $table->boolean('is_fav')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('published_at')->nullable();
            $table->text('writer')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
