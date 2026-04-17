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
        Schema::create('regulatory_impact_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regulatory_impact_id')->constrained('regulatory_impacts')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('citizen_id')->nullable();
            $table->enum('comment_type', ['admin', 'public'])->default('admin');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulatory_impact_comments');
    }
};
