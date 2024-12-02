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
        Schema::create('artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', '128')->nullable();
            $table->text('description')->nullable();
            $table->string('image', '128')->nullable();
            $table->string('country', 32)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('website', 128)->nullable();
            $table->string('facebook', 256)->nullable();
            $table->string('twitter', 256)->nullable();
            $table->string('instagram', 256)->nullable();
            $table->string('youtube', 256)->nullable();
            $table->string('telegram', 256)->nullable();
            $table->integer('public')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
