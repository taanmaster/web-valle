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
        Schema::table('regulatory_agenda_suggestions', function (Blueprint $table) {
            //
            $table->bigInteger('regulation_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regulatory_agenda_suggestions', function (Blueprint $table) {
            $table->dropColumn('regulation_id');
        });
    }
};
