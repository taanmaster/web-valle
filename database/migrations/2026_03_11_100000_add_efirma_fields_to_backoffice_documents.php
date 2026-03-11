<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->string('efirma_document_id')->nullable()->after('stamp_s3_url');
            $table->string('efirma_status')->nullable()->after('efirma_document_id');
            $table->text('efirma_iframe_url')->nullable()->after('efirma_status');
            $table->longText('efirma_signatures')->nullable()->after('efirma_iframe_url');
            $table->text('efirma_error')->nullable()->after('efirma_signatures');
            $table->timestamp('efirma_sent_at')->nullable()->after('efirma_error');
        });
    }

    public function down(): void
    {
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->dropColumn([
                'efirma_document_id',
                'efirma_status',
                'efirma_iframe_url',
                'efirma_signatures',
                'efirma_error',
                'efirma_sent_at',
            ]);
        });
    }
};
