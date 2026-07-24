<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Folio alfanumérico de la solicitud, generado al momento de crearse
     * a partir de la fecha, hora e id.
     */
    public function up(): void
    {
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            $table->string('folio')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            $table->dropColumn('folio');
        });
    }
};
