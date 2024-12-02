<div class="grid grid-cols-3 gap-4">
    <div class="col-span-2">
        <x-input-label for="i-android-open-ad" :value="__('Android · App Open Ads')" />
        <x-text-input id="i-android-open-ad" name="android_app_open_ad" type="text" class="mt-1 block w-full"
            :value="old('android_app_open_ad', config('settings.android_app_open_ad'))" />
        <x-input-error class="mt-2" :messages="$errors->get('android_app_open_ad')" />
    </div>
    <div>
        <x-input-label for="i-android-open-ad-status" :value="__('Status')" />
        <x-input-select id="i-android-open-ad-status" name="android_app_open_status" class="mt-1 block w-full"
            :options="[0 => __('Off'), 1 => __('On')]" :selected="old('android_app_open_status', config('settings.android_app_open_status'))" />
        <x-input-error class="mt-2" :messages="$errors->get('android_app_open_status')" />
    </div>
</div>
<div class="grid grid-cols-4 gap-4">
    <div class="col-span-2">
        <x-input-label for="i-android-interstitial-ad" :value="__('Android · Interstitial Ads')" />
        <x-text-input id="i-android-interstitial-ad" name="android_interstitial_ad" type="text"
            class="mt-1 block w-full" :value="old('android_interstitial_ad', config('settings.android_interstitial_ad'))" />
        <x-input-error class="mt-2" :messages="$errors->get('android_interstitial_ad')" />
    </div>
    <div>
        <x-input-label for="i-android-click-ad" :value="__('Ad Click')" />
        <x-text-input id="i-android-click-ad" name="android_max_interstitial_ad_click" type="number"
            class="mt-1 block w-full" :value="old('android_max_interstitial_ad_click', config('settings.android_max_interstitial_ad_click'))" />
        <x-input-error class="mt-2" :messages="$errors->get('android_max_interstitial_ad_click')" />
    </div>
    <div>
        <x-input-label for="i-android-click-status" :value="__('Status')" />
        <x-input-select id="i-android-click-status" name="android_interstitial_status" class="mt-1 block w-full"
            :options="[0 => __('Off'), 1 => __('On')]" :selected="old('android_interstitial_status', config('settings.android_interstitial_status'))" />
        <x-input-error class="mt-2" :messages="$errors->get('android_interstitial_status')" />
    </div>
</div>
<hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
<div class="grid grid-cols-3 gap-4">
    <div class="col-span-2">
        <x-input-label for="i-ios-open-ad" :value="__('iOS · App Open Ads')" />
        <x-text-input id="i-ios-open-ad" name="ios_app_open_ad" type="text" class="mt-1 block w-full"
            :value="old('ios_app_open_ad', config('settings.ios_app_open_ad'))" />
        <x-input-error class="mt-2" :messages="$errors->get('ios_app_open_ad')" />
    </div>
    <div>
        <x-input-label for="i-ios-open-status" :value="__('Status')" />
        <x-input-select id="i-ios-open-status" name="ios_app_open_status" class="mt-1 block w-full"
            :options="[0 => __('Off'), 1 => __('On')]" :selected="old('ios_app_open_status', config('settings.ios_app_open_status'))" />
        <x-input-error class="mt-2" :messages="$errors->get('ios_app_open_status')" />
    </div>
</div>
<div class="grid grid-cols-4 gap-4">
    <div class="col-span-2">
        <x-input-label for="i-ios-interstitial-ad" :value="__('iOS · Interstitial Ads')" />
        <x-text-input id="i-ios-interstitial-ad" name="ios_interstitial_ad" type="text" class="mt-1 block w-full"
            :value="old('ios_interstitial_ad', config('settings.ios_interstitial_ad'))" />
        <x-input-error class="mt-2" :messages="$errors->get('ios_interstitial_ad')" />
    </div>
    <div>
        <x-input-label for="i-ios-click-ad" :value="__('Ad Click')" />
        <x-text-input id="i-ios-click-ad" name="ios_max_interstitial_ad_click" type="number" class="mt-1 block w-full"
            :value="old('ios_max_interstitial_ad_click', config('settings.ios_max_interstitial_ad_click'))" />
        <x-input-error class="mt-2" :messages="$errors->get('ios_max_interstitial_ad_click')" />
    </div>
    <div>
        <x-input-label for="i-ios-interstitial-ad-status" :value="__('Status')" />
        <x-input-select id="i-ios-interstitial-ad-status" name="ios_interstitial_status" class="mt-1 block w-full"
            :options="[0 => __('Off'), 1 => __('On')]" :selected="old('ios_interstitial_ad', config('settings.ios_interstitial_status'))" />
        <x-input-error class="mt-2" :messages="$errors->get('ios_interstitial_status')" />
    </div>
</div>
