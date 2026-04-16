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