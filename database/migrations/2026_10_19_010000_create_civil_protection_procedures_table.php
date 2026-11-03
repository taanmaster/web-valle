<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('civil_protection_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // technical_opinion = Opinión técnica · permit = Permiso
            $table->string('type')->default('technical_opinion');
            $table->text('description');
            $table->string('folio_prefix', 5)->unique();
            $table->unsignedInteger('validity_days');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('civil_protection_procedures');
    }
};
