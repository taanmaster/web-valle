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
        Schema::table('sare_request_files', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('file_extension');
            $table->bigInteger('file_size')->nullable()->after('file_name');
            $table->string('file_type')->nullable()->after('file_size');
            $table->text('s3_asset_url')->nullable()->after('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sare_request_files', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'file_size', 'file_type', 's3_asset_url']);
        });
    }
};
