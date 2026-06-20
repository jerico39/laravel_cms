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
        Schema::table('survey_votes', function (Blueprint $table) {
            $table->foreign(['survey_id'])->references(['id'])->on('surveys')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['survey_option_id'])->references(['id'])->on('survey_options')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_votes', function (Blueprint $table) {
            $table->dropForeign('survey_votes_survey_id_foreign');
            $table->dropForeign('survey_votes_survey_option_id_foreign');
        });
    }
};
