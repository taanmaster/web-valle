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
        Schema::create('document_certificates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('folio', 10)->unique();
            $table->string('full_name');
            $table->text('address');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('new');

            $table->string('filename')->nullable();
            $table->string('request')->nullable();
            $table->string('request_intent')->nullable();

            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_certificates');
    }
};
