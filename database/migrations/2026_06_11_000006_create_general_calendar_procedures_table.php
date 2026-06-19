<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_calendar_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('dependencia')->nullable();
            $table->text('note')->nullable();
            $table->json('attention_days')->nullable();
            $table->time('attention_start')->nullable();
            $table->time('attention_end')->nullable();
            $table->boolean('requires_id')->default(false);
            $table->boolean('status')->default(true);
            $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_calendar_procedures');
    }
};
