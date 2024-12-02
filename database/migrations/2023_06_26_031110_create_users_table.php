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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->string('username')->index('username')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('role')->default(0);
            $table->string('first_name', 32)->index('first_name')->default('');
            $table->string('last_name', 32)->index('last_name')->default('');
            $table->string('country', 32)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('website', 128)->nullable();
            $table->text('description')->nullable();
            $table->string('facebook', 256)->nullable();
            $table->string('twitter', 256)->nullable();
            $table->string('instagram', 256)->nullable();
            $table->string('youtube', 256)->nullable();
            $table->string('telegram', 256)->nullable();
            $table->string('image', 128)->default('default.png');
            $table->string('cover', 128)->default('default.png');
            $table->tinyInteger('gender')->default('0');
            $table->integer('online')->default(0);
            $table->tinyInteger('offline')->default(0);
            $table->string('ip', 45);
            $table->integer('private')->default(0);
            $table->integer('suspended')->default(0)->index('suspended');
            $table->string('type', 128)->default('normal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
