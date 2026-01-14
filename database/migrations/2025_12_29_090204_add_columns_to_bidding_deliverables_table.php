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
        Schema::table('bidding_deliverables', function (Blueprint $table) {

            $table->decimal('quantity', 15, 2)->nullable();
            $table->string('unit')->nullable();

            $table->text('description')->nullable();
            $table->string('name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bidding_deliverables', function (Blueprint $table) {

            $table->dropColumn('quantity');
            $table->dropColumn('unit');
            $table->dropColumn('description');
            $table->dropColumn('name');

        });
    }
};
