<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'streak_count')) {
                $table->integer('streak_count')->default(0);
            }

            if (!Schema::hasColumn('profiles', 'puzzles_solved')) {
                $table->integer('puzzles_solved')->default(0);
            }

            if (!Schema::hasColumn('profiles', 'time_bonus_seconds')) {
                $table->integer('time_bonus_seconds')->default(0);
            }

            if (!Schema::hasColumn('profiles', 'last_daily_reward_claimed_at')) {
                $table->timestamp('last_daily_reward_claimed_at')->nullable();
            }

            if (!Schema::hasColumn('profiles', 'last_puzzle_played_at')) {
                $table->timestamp('last_puzzle_played_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        //
    }
};