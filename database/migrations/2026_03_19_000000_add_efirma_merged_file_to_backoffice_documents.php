<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->text('efirma_merged_file')->nullable()->after('efirma_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->dropColumn('efirma_merged_file');
        });
    }
};
