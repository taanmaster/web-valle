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
        Schema::table('citizens', function (Blueprint $table) {

            $table->string('ine_number')->after('curp')->nullable();
            $table->string('ine_section')->after('ine_number')->nullable();
            $table->longText('address')->after('ine_section')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {

            $table->dropColumn('ine_number');
            $table->dropColumn('ine_section');
            $table->dropColumn('address');
        });
    }
};
