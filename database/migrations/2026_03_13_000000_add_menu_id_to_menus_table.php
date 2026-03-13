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
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('menu_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->integer('sort')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn(['menu_id', 'title', 'url', 'sort']);
        });
    }
};