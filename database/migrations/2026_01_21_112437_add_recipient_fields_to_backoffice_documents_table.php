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
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->foreignId('sent_to_user_id')->nullable()->after('assigned_to')->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable()->after('sent_to_user_id');
            $table->text('sent_message')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backoffice_documents', function (Blueprint $table) {
            $table->dropForeign(['sent_to_user_id']);
            $table->dropColumn(['sent_to_user_id', 'sent_at', 'sent_message']);
        });
    }
};
