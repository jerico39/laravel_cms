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
        Schema::table('news_tag', function (Blueprint $table) {
            $table->foreign(['news_id'])->references(['id'])->on('news')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tag_id'])->references(['id'])->on('tags')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_tag', function (Blueprint $table) {
            $table->dropForeign('news_tag_news_id_foreign');
            $table->dropForeign('news_tag_tag_id_foreign');
        });
    }
};
