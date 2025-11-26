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
        Schema::create('acquisition_inventory_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('type');

            $table->integer('quantity');
            $table->text('description')->nullable();

            $table->string('reception_file')->nullable();
            $table->string('request_file')->nullable();
            $table->string('approval_file')->nullable();

            $table->text('validation')->nullable();
            $table->string('destiny')->nullable();
            $table->string('responsable')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquisition_inventory_movements');
    }
};
