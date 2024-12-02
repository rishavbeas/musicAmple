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
        Schema::create('tracks', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->string('artist_id',255)->index('artist_id');
            $table->string('title', '128')->index('title');
            $table->text('description')->nullable();
            $table->string('name', 512)->index('name');
            $table->integer('album_id')->index('album_id');
            $table->string('art', 512);
            $table->string('lyric', 512);
            $table->timestamp('release')->nullable();
            $table->integer('size');
            $table->integer('download');
            $table->integer('public')->default(1);
            $table->integer('likes')->default(0);
            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
