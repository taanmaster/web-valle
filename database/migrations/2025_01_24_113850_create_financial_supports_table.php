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
        Schema::create('financial_supports', function (Blueprint $table) {
            $table->id();

            $table->integer('citizen_id')->unsigned()->nullable();
            
            $table->string('int_num')->nullable();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('qty')->nullable();
            $table->string('receipt_num')->nullable();

            $table->integer('type_id')->unsigned();

            $table->string('phone')->nullable();
            $table->string('limit_qty')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_supports');
    }
};
