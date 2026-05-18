<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_blog_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_blog_id')->constrained('general_blogs')->cascadeOnDelete();
            $table->string('image_path'); // full S3 URL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_blog_images');
    }
};
