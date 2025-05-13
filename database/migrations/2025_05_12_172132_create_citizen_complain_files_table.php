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
        Schema::create('citizen_complain_files', function (Blueprint $table) {
            $table->id();
            $table->integer('complain_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_extension')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_complain_files');
    }
};
