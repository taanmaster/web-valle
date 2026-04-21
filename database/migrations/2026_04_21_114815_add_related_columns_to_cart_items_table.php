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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('related_model_type')->nullable()->after('quantity');
            $table->unsignedBigInteger('related_model_id')->nullable()->after('related_model_type');
            $table->string('related_folio')->nullable()->after('related_model_id');
            $table->unsignedBigInteger('related_user_id')->nullable()->after('related_folio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['related_model_type', 'related_model_id', 'related_folio', 'related_user_id']);
        });
    }
};
