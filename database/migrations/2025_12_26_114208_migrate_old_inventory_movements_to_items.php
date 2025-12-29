<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $movements = DB::table('acquisition_inventory_movements')->get();

        foreach ($movements as $movement) {
            if ($movement->material_id && $movement->quantity) {
                DB::table('acquisition_inventory_movement_items')->insert([
                    'movement_id' => $movement->id,
                    'material_id' => $movement->material_id,
                    'quantity' => $movement->quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('acquisition_inventory_movement_items')->truncate();
    }
};
