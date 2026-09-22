<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $existing = DB::table('service_requests')
            ->whereNotNull('regulation_media')
            ->where('regulation_media', '!=', '')
            ->pluck('regulation_media', 'id');

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('regulation_media');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            // El medio de difusión oficial ahora es de selección múltiple
            $table->json('regulation_media')->nullable()->after('regulation_name');
        });

        foreach ($existing as $id => $value) {
            DB::table('service_requests')->where('id', $id)->update([
                'regulation_media' => json_encode([$value]),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('regulation_media');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('regulation_media')->nullable()->after('regulation_name');
        });
    }
};
