<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hacemos la columna nullable usando SQL directo para evitar dependencia de doctrine/dbal
        DB::statement('ALTER TABLE `urban_dev_requests` MODIFY `inspector_id` BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volvemos a dejarla NOT NULL con valor por defecto 0
        DB::statement('ALTER TABLE `urban_dev_requests` MODIFY `inspector_id` BIGINT UNSIGNED NOT NULL DEFAULT 0');
    }
};
