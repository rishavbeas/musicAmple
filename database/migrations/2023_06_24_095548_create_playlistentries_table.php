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
        Schema::create('playlistentries', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->integer('playlist')->index('playlist');
            $table->integer('track');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlistentries');
    }
};
