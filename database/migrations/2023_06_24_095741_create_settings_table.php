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
        Schema::create('settings', function (Blueprint $table) {
            $table->string('title', 64);
            $table->string('logo', 128);
            $table->string('tagline', 128);
            $table->integer('paginate');
            $table->integer('m_per_page');
            $table->integer('e_per_page');
            $table->integer('s_per_page');
            $table->integer('mail');
            $table->tinyInteger('email_activation');
            $table->integer('smtp_email');
            $table->string('smtp_host', 128)->nullable();
            $table->integer('smtp_port');
            $table->string('smtp_encryption',32);
            $table->string('smtp_username', 128)->nullable();
            $table->string('smtp_password', 128)->nullable();
            $table->string('locale', 32);
            $table->string('timezone', 32);
            $table->mediumText('android_interstitial_ad')->nullable();
            $table->mediumText('android_max_interstitial_ad_click');
            $table->mediumText('android_app_open_ad')->nullable();
            $table->mediumText('ios_interstitial_ad')->nullable();
            $table->mediumText('ios_max_interstitial_ad_click');
            $table->mediumText('ios_app_open_ad')->nullable();
            $table->integer('android_interstitial_status');
            $table->integer('android_app_open_status');
            $table->integer('ios_interstitial_status');
            $table->integer('ios_app_open_status');
            $table->string('facebook', 256)->nullable();
            $table->string('twitter', 256)->nullable();
            $table->string('instagram', 256)->nullable();
            $table->string('youtube', 256)->nullable();
            $table->string('telegram', 256)->nullable();
            $table->string('tos_url', 128)->nullable();
            $table->string('privacy_url', 128)->nullable();
            $table->string('cookie_url', 128)->nullable();
            $table->string('ps_url', 256)->nullable();
            $table->string('as_url', 256)->nullable();
            $table->mediumtext('custom_js')->nullable();
        });

        DB::table('settings')->insert([
            'title' => 'Flutter Music Pro',
            'logo' => 'logo.png',
            'tagline' => 'the free streaming music player',
            'paginate' => 10,
            'm_per_page' => 50,
            'e_per_page' => 10,
            's_per_page' => 25,
            'mail' => 1,
            'email_activation' => 0,
            'smtp_email' => 0,
            'smtp_host' => '',
            'smtp_port' => 0,
            'smtp_encryption' => 'tls',
            'smtp_username' => '',
            'smtp_password' => '',
            'locale' => 'en',
            'timezone' => 'UTC',
            'android_interstitial_ad'=> 'ca-app-pub-3940256099942544/1033173712',
            'android_max_interstitial_ad_click'=> 5,
            'android_app_open_ad'=> 'ca-app-pub-3940256099942544/3419835294',
            'ios_interstitial_ad'=> 'ca-app-pub-3940256099942544/4411468910',
            'ios_max_interstitial_ad_click'=> 5,
            'ios_app_open_ad'=> 'ca-app-pub-3940256099942544/5662855259',
            'android_interstitial_status' => 1,
            'android_app_open_status' => 1,
            'ios_interstitial_status' => 1,
            'ios_app_open_status' => 1,
            'tos_url' => '',
            'privacy_url' => '',
            'cookie_url' => '',
            'custom_js'=> '',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
