Schema::create('shop_items', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('type');
    $table->integer('value');
    $table->integer('price');
    $table->timestamps();
});