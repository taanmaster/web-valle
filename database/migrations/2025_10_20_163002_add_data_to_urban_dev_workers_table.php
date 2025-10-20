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
        Schema::table('urban_dev_workers', function (Blueprint $table) {
            $table->string('email')->nullable()->after('position');
            $table->string('phone')->nullable()->after('email');
            $table->string('extension')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urban_dev_workers', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'extension']);
        });
    }
};
