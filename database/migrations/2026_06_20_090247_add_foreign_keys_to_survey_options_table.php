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
        Schema::table('survey_options', function (Blueprint $table) {
            $table->foreign(['survey_id'])->references(['id'])->on('surveys')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_options', function (Blueprint $table) {
            $table->dropForeign('survey_options_survey_id_foreign');
        });
    }
};
