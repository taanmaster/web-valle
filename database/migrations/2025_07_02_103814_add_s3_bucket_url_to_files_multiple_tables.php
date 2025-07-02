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
        Schema::table('citizen_files', function (Blueprint $table) {
            $table->string('s3_asset_url')->nullable()->after('description');
            $table->string('filesize')->nullable()->after('file_extension');
        });

        Schema::table('gazette_files', function (Blueprint $table) {
            $table->string('s3_asset_url')->nullable()->after('description');
            $table->string('filesize')->nullable()->after('file_extension');
        });

        Schema::table('transparency_files', function (Blueprint $table) {
            $table->string('s3_asset_url')->nullable()->after('description');
            $table->string('filesize')->nullable()->after('file_extension');
        });

        Schema::table('transparency_documents', function (Blueprint $table) {
            $table->string('s3_asset_url')->nullable()->after('description');
            $table->string('filesize')->nullable()->after('file_extension');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizen_files', function (Blueprint $table) {
            $table->dropColumn('s3_asset_url');
            $table->dropColumn('filesize');
        });

        Schema::table('gazette_files', function (Blueprint $table) {
            $table->dropColumn('s3_asset_url');
            $table->dropColumn('filesize');
        });

        Schema::table('transparency_files', function (Blueprint $table) {
            $table->dropColumn('s3_asset_url');
            $table->dropColumn('filesize');
        });
        
        Schema::table('transparency_documents', function (Blueprint $table) {
            $table->dropColumn('s3_asset_url');
            $table->dropColumn('filesize');
        });
    }
};
