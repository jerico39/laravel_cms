<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('survey_comments', function (Blueprint $table) {
        $table->foreignId('vote_id')
            ->after('id')
            ->constrained('survey_votes')
            ->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('survey_comments', function (Blueprint $table) {
        $table->dropForeign(['vote_id']);
        $table->dropColumn('vote_id');
    });
}
};
