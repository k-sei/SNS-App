<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('talkrooms', function (Blueprint $table) {
            $table->string('image')->nullable()->comment('トークルームの画像')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talkrooms', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
