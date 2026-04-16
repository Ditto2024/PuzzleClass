Schema::create('user_puzzle_attempts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id');
    $table->foreignId('puzzle_id');
    $table->string('submitted_answer');
    $table->boolean('used_hint')->default(false);
    $table->boolean('is_correct');
    $table->integer('earned_points')->default(0);
    $table->timestamps();
});