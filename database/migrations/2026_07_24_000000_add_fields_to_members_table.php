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
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('members', 'email')) {
                $table->string('email')->unique()->after('name');
            }
            if (!Schema::hasColumn('members', 'password')) {
                $table->string('password')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('members', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('members', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
