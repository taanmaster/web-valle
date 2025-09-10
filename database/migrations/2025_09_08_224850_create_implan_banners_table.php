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
        Schema::create('implan_banners', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->boolean('show_text')->default(true);

            $table->string('image')->required();
            $table->string('image_responsive')->nullable();

            $table->boolean('is_active')->default(true);

            $table->string('priority')->nullable();

            $table->string('video_background')->nullable();
            $table->boolean('video_autoplay')->nullable()->default(false);
            $table->boolean('video_controls')->nullable()->default(false);
            $table->boolean('video_loop')->nullable()->default(false);

            $table->string('hex_text_title')->nullable();
            $table->string('hex_text_subtitle')->nullable();
            $table->string('hex_button')->nullable();

            $table->string('link')->nullable();
            $table->string('text_button')->nullable();
            $table->boolean('has_button')->default(false);

            $table->string('hex_text_button')->nullable();
            $table->string('position')->nullable();

            $table->boolean('is_promotional')->default(false)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implan_banners');
    }
};
