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
        Schema::create('simplification_agenda_suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('simplification_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('simplification_id')
                  ->references('id')
                  ->on('simplification_agendas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simplification_agenda_suggestions');
    }
};
