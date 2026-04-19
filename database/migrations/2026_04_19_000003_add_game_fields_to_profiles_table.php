<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('streak_count')->default(0)->after('hints');
            $table->integer('puzzles_solved')->default(0)->after('streak_count');
            $table->integer('time_bonus_seconds')->default(0)->after('puzzles_solved');
            $table->timestamp('last_daily_reward_claimed_at')->nullable()->after('time_bonus_seconds');
            $table->timestamp('last_puzzle_played_at')->nullable()->after('last_daily_reward_claimed_at');
            $table->string('avatar')->nullable()->after('last_puzzle_played_at');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'streak_count',
                'puzzles_solved',
                'time_bonus_seconds',
                'last_daily_reward_claimed_at',
                'last_puzzle_played_at',
                'avatar',
            ]);
        });
    }
};