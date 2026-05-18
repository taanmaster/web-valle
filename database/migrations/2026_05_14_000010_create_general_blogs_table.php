<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('type');           // welfare | training | events
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content_1')->nullable();
            $table->longText('content_2')->nullable();
            $table->string('hero_img')->nullable(); // full S3 URL
            $table->boolean('is_active')->default(true);
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_blogs');
    }
};
