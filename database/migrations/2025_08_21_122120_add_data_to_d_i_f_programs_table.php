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
        Schema::table('d_i_f_programs', function (Blueprint $table) {
            $table->string('manager')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('d_i_f_programs', function (Blueprint $table) {
            $table->dropColumn('manager');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
