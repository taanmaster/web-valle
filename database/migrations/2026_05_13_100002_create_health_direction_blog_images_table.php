<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_direction_blog_images', function (Blueprint $table) {
            $table->id();
            $table->integer('health_direction_blog_id')->unsigned();
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_direction_blog_images');
    }
};
