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
        Schema::create('summons', function (Blueprint $table) {
            $table->id();

            $table->datetime('expiration_date')->nullable();
            $table->string('folio')->nullable();
            $table->string('number')->nullable();

            $table->unsignedBigInteger('citizen_id');
            $table->string('full_name')->nullable();

            $table->string('street')->nullable();
            $table->string('external_number')->nullable();
            $table->string('suburb')->nullable();

            $table->longText('details')->nullable();
            $table->string('file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summons');
    }
};
