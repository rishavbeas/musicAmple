<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', '128')->index('title');
            $table->string('type', 32);
            $table->text('value')->nullable();
            $table->integer('sort_id')->nullable();
            $table->integer('public')->default(1);
            $table->timestamps();
        });
        $sample_ads = json_encode(array("android" => 'ca-app-pub-3940256099942544/6300978111', "ios" => 'ca-app-pub-3940256099942544/2934735716'), true);
        DB::table('widgets')->insert([
            ['title' => 'Slider Latest Music', 'type' => 'slider', 'value' => NULL, 'sort_id' => '1', "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ['title' => 'Artist', 'type' => 'artists', 'value' => NULL, 'sort_id' => '2', "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ['title' => 'Albums', 'type' => 'albums', 'value' => NULL, 'sort_id' => '3', "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ['title' => 'Productions', 'type' => 'productions', 'value' => NULL, 'sort_id' => '4', "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ['title' => 'Admob Banner Ads', 'type' => 'ads', 'value' => $sample_ads, 'sort_id' => '5', "created_at" => Carbon::now(), "updated_at" => Carbon::now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
