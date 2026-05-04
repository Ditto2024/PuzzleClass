<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'reduce_animation')) {
                $table->boolean('reduce_animation')->default(false);
            }

            if (! Schema::hasColumn('profiles', 'auto_next_enabled')) {
                $table->boolean('auto_next_enabled')->default(true);
            }
        });
    }

    public function down(): void
    {
        //
    }
};