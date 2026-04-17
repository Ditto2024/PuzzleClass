<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puzzles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->string('answer');
            $table->text('hint')->nullable();
            $table->integer('time_limit')->default(60);
            $table->integer('bonus_points')->default(50);
            $table->integer('order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puzzles');
    }
};