<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'time_boost_30')) {
                $table->integer('time_boost_30')->default(0);
            }
        });
    }

    public function down(): void
    {
        //
    }
};