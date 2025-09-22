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
        Schema::table('d_i_f_stock_movements', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->after('id')->nullable(); // Este sirve para vincular una salida a una entrada.
            $table->string('movement_sub_type')->after('movement_type')->nullable(); // Este campo clasifica el tipo de movimiento en subtipos para clasificar los movimientos.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('d_i_f_stock_movements', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('movement_sub_type');
        });
    }
};
