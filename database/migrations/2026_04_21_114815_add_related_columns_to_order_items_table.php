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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('related_model_type')->nullable()->after('subtotal');
            $table->unsignedBigInteger('related_model_id')->nullable()->after('related_model_type');
            $table->string('related_folio')->nullable()->after('related_model_id');
            $table->unsignedBigInteger('related_user_id')->nullable()->after('related_folio');

            $table->index(['related_model_type', 'related_model_id'], 'order_items_related_model_index');
            $table->index('related_folio', 'order_items_related_folio_index');
            $table->index('related_user_id', 'order_items_related_user_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_related_model_index');
            $table->dropIndex('order_items_related_folio_index');
            $table->dropIndex('order_items_related_user_index');
            $table->dropColumn(['related_model_type', 'related_model_id', 'related_folio', 'related_user_id']);
        });
    }
};
