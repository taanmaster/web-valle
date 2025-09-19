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
        Schema::create('d_i_f_stock_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('variant_id');
            $table->string('movement_type')->default('inbound');
            $table->integer('quantity');
            $table->date('date');
            $table->date('expiration_date')->nullable();
            $table->string('external_reference')->nullable();
            $table->json('additional_info')->nullable();

            $table->index(['movement_type', 'created_at']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_i_f_stock_movements');
    }
};
