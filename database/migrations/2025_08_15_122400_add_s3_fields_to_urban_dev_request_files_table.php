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
        Schema::table('urban_dev_request_files', function (Blueprint $table) {
            $table->bigInteger('filesize')->nullable()->after('file_extension');
            $table->text('s3_asset_url')->nullable()->after('filesize');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urban_dev_request_files', function (Blueprint $table) {
            $table->dropColumn(['filesize', 's3_asset_url']);
        });
    }
};
