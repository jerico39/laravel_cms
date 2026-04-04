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
        Schema::create('survey_votes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
    $table->foreignId('survey_option_id')->constrained()->cascadeOnDelete();
    $table->string('user_ip')->nullable();
    $table->timestamps();

    //$table->unique(['survey_id', 'user_ip']); // 重複防止
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_votes');
    }
};
