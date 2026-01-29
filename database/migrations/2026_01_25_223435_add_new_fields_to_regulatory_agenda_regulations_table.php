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
        Schema::table('regulatory_agenda_regulations', function (Blueprint $table) {
            $table->text('legal_basis_law')->nullable()->after('justification');
            $table->text('legal_basis_article')->nullable()->after('legal_basis_law');
            $table->text('proposal_alternatives')->nullable()->after('legal_basis_article');
            $table->text('burocratic_cost_benefict')->nullable()->after('proposal_alternatives');
            $table->text('simplification_oportunities')->nullable()->after('burocratic_cost_benefict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regulatory_agenda_regulations', function (Blueprint $table) {
            $table->dropColumn([
                'legal_basis_law',
                'legal_basis_article',
                'proposal_alternatives',
                'burocratic_cost_benefict',
                'simplification_oportunities'
            ]);
        });
    }
};
