Schema::create('quests', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->integer('reward_points');
    $table->integer('reward_xp');
    $table->integer('order');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});