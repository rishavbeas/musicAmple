<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            $settings = Settings::all()->first();
            config(['app.name' => $settings['title']]);
            config(['settings.tagline' => $settings['tagline']]);
            config(['settings.logo' => $settings['logo']]);
            config(['settings.locale' => $settings['locale']]);
            config(['settings.timezone' => $settings['timezone']]);
            config(['settings.cookie_url' => $settings['cookie_url']]);
            config(['settings.tos_url' => $settings['tos_url']]);
            config(['settings.privacy_url' => $settings['privacy_url']]);
            config(['settings.paginate' => $settings['paginate']]);
            config(['settings.e_per_page' => $settings['e_per_page']]);
            config(['settings.m_per_page' => $settings['m_per_page']]);
            config(['settings.s_per_page' => $settings['s_per_page']]);
            config(['settings.custom_js' => $settings['custom_js']]);
            config(['settings.smtp_email' => $settings['smtp_email']]);
            config(['settings.smtp_host' => $settings['smtp_host']]);
            config(['settings.smtp_port' => $settings['smtp_port']]);
            config(['settings.smtp_encryption' => $settings['smtp_encryption']]);
            config(['settings.smtp_username' => $settings['smtp_username']]);
            config(['settings.smtp_password' => $settings['smtp_password']]);
            config(['settings.android_interstitial_ad' => $settings['android_interstitial_ad']]);
            config(['settings.android_max_interstitial_ad_click' => $settings['android_max_interstitial_ad_click']]);
            config(['settings.android_app_open_ad' => $settings['android_app_open_ad']]);
            config(['settings.ios_interstitial_ad' => $settings['ios_interstitial_ad']]);
            config(['settings.ios_max_interstitial_ad_click' => $settings['ios_max_interstitial_ad_click']]);
            config(['settings.ios_app_open_ad' => $settings['ios_app_open_ad']]);
            config(['settings.android_interstitial_status' => $settings['android_interstitial_status']]);
            config(['settings.android_app_open_status' => $settings['android_app_open_status']]);
            config(['settings.ios_interstitial_status' => $settings['ios_interstitial_status']]);
            config(['settings.ios_app_open_status' => $settings['ios_app_open_status']]);
            config(['settings.facebook' => $settings['facebook']]);
            config(['settings.twitter' => $settings['twitter']]);
            config(['settings.youtube' => $settings['youtube']]);
            config(['settings.instagram' => $settings['instagram']]);
            config(['settings.telegram' => $settings['telegram']]);
            config(['settings.ps_url' => $settings['ps_url']]);
            config(['settings.as_url' => $settings['as_url']]);
            // config(['mail.default' => config('settings.email_driver')]);
            config(['mail.mailers.smtp.host' => config('settings.smtp_host')]);
            config(['mail.mailers.smtp.port' => config('settings.smtp_port')]);
            config(['mail.mailers.smtp.encryption' => config('settings.smtp_encryption')]);
            config(['mail.mailers.smtp.username' => config('settings.smtp_username')]);
            config(['mail.mailers.smtp.password' => config('settings.smtp_password')]);
            // config(['mail.from.address' => config('settings.email_address')]);
            config(['mail.from.name' => $settings['title']]);
        } catch (\Exception $e) {
        }
    }
}
