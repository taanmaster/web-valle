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
        Schema::table('backoffice_dependencies', function (Blueprint $table) {
            $table->string('type', 255)->nullable()->after('responsible_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backoffice_dependencies', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
