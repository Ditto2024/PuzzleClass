<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'time_boost_15')) {
                $table->integer('time_boost_15')->default(0);
            }

            if (! Schema::hasColumn('profiles', 'sound_enabled')) {
                $table->boolean('sound_enabled')->default(true);
            }

            if (! Schema::hasColumn('profiles', 'dark_mode')) {
                $table->boolean('dark_mode')->default(false);
            }
        });
    }

    public function down(): void
    {
        //
    }
};