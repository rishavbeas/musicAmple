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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->string('track', 11);
            $table->integer('parent');
            $table->text('content');
            $table->integer('type');
            $table->tinyInteger('reason');
            $table->integer('by');
            $table->integer('state')->default(0)->index('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
