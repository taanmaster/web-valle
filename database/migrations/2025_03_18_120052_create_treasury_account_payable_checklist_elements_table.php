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
        Schema::create('treasury_account_payable_checklist_elements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('checklist_id')->unsigned();
            
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('order')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_account_payable_checklist_elements');
    }
};
