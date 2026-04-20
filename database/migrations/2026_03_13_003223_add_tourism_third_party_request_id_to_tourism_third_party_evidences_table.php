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
        Schema::table('tourism_third_party_evidences', function (Blueprint $table) {
            $table->unsignedBigInteger('tourism_third_party_request_id')->nullable()->after('id');

            $table->foreign('tourism_third_party_request_id', 'ttp_evidences_request_fk')
                ->references('id')
                ->on('tourism_third_party_requests')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourism_third_party_evidences', function (Blueprint $table) {
            $table->dropForeign('ttp_evidences_request_fk');
            $table->dropColumn('tourism_third_party_request_id');
        });
    }
};
