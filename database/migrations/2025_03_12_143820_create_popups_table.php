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
        Schema::create('popups', function (Blueprint $table) {
            $table->id();

            $table->string('title')->required();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();

            $table->string('text_button')->nullable();
            $table->boolean('has_button')->default(false);
            $table->string('link')->nullable();
            $table->string('hex', 50)->nullable();

            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);

            $table->boolean('show_on_exit')->nullable();
            $table->boolean('show_on_enter')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
