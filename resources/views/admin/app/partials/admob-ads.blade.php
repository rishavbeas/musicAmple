<div>
    <div class="py-4">
        <x-input-label for="i-ads-android" :value="__('Android Banner Ads')" />
        <x-text-input id="i-ads-android" name="ads_android" type="text" class="mt-1 block w-full" :value="old('ads_android',$androidAds ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('ads_android')" />
    </div>
    <div class="py-4">
        <x-input-label for="i-ads-ios" :value="__('iOS Banner Ads')" />
        <x-text-input id="i-ads-ios" name="ads_ios" type="text" class="mt-1 block w-full" :value="old('ads_ios',$iosAds ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('ads_ios')" />
    </div>
</div>
