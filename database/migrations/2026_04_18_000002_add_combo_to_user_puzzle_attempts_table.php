<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_puzzle_attempts', function (Blueprint $table) {
            $table->integer('combo_count')->default(0)->after('earned_points');
        });
    }

    public function down(): void
    {
        Schema::table('user_puzzle_attempts', function (Blueprint $table) {
            $table->dropColumn('combo_count');
        });
    }
};