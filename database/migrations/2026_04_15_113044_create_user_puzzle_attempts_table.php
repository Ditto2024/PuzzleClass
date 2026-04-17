<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_puzzle_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('puzzle_id')->constrained()->cascadeOnDelete();
            $table->string('submitted_answer')->nullable();
            $table->boolean('used_hint')->default(false);
            $table->boolean('is_correct')->default(false);
            $table->integer('earned_points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_puzzle_attempts');
    }
};