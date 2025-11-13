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
        Schema::table('supplier_approvals', function (Blueprint $table) {
            $table->string('link_name')->nullable()->after('link_approval');
            $table->string('director_name')->nullable()->after('director_approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_approvals', function (Blueprint $table) {
            $table->dropColumn(['link_name', 'director_name']);
        });
    }
};
