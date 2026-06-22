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
        Schema::create('survey_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_id')->index('survey_comments_vote_id_foreign');
            $table->unsignedBigInteger('survey_id')->index('survey_comments_survey_id_foreign');
            $table->text('comment');
            $table->timestamps();
            $table->unsignedBigInteger('survey_option_id')->nullable()->index('survey_comments_survey_option_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_comments');
    }
};
