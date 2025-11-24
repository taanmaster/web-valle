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
        Schema::create('acquisition_materials', function (Blueprint $table) {
            $table->id();

            $table->string('sku')->unique();
            $table->string('title');
            $table->boolean('status')->default(true);

            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('dependency_name')->nullable();
            $table->string('current_stock')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquisition_materials');
    }
};
