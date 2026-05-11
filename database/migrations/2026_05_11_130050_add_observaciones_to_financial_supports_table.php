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
        Schema::table('financial_supports', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('limit_qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_supports', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};
