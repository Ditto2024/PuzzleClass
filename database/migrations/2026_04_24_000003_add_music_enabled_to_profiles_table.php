<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'music_enabled')) {
                $table->boolean('music_enabled')->default(false);
            }
        });
    }

    public function down(): void
    {
        //
    }
};