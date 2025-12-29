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
        if (Schema::hasTable('acquisition_inventory_movement_items')) {
            return;
        }

        Schema::create('acquisition_inventory_movement_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('movement_id')
                ->constrained('acquisition_inventory_movements')
                ->cascadeOnDelete();

            $table->foreignId('material_id')
                ->constrained('acquisition_materials')
                ->restrictOnDelete();

            $table->integer('quantity');

            $table->timestamps();

            $table->unique(['movement_id', 'material_id'], 'aimi_mov_mat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquisition_inventory_movement_items');
    }
};
