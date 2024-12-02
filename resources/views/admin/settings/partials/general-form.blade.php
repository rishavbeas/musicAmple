<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', config('app.name'))" required />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>
<div>
    <x-input-label for="tagline" :value="__('Tagline')" />
    <x-text-input id="tagline" name="tagline" type="text" class="mt-1 block w-full" :value="old('tagline', config('settings.tagline'))" />
    <x-input-error class="mt-2" :messages="$errors->get('tagline')" />
</div>
<div>
    <x-input-label for="logo" :value="__('Logo')" />
    <input id="logo" class="px-4 py-2 mt-4 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="logo" type="file" accept="jpeg,png,bmp,gif,svg,webp">
</div>
<div>
    <label for="i-timezone"
        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Timezone') }}</label>
    <div class="relative mt-2 rounded-md shadow-sm">
        <select name="timezone" id="i-timezone"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach (timezone_identifiers_list() as $value)
                <option value="{{ $value }}" @if (
                    (old('timezone') !== null && old('timezone') == $value) ||
                        (config('settings.timezone') == $value && old('timezone') == null)) selected @endif>{{ $value }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <x-input-label for="tos" :value="__('Terms of Use')" />
    <x-text-input id="tos" name="tos_url" type="text" class="mt-1 block w-full" :value="old('tos_url', config('settings.tos_url'))" />
    <x-input-error class="mt-2" :messages="$errors->get('tos_url')" />
</div>
<div>
    <x-input-label for="privacy" :value="__('Privacy Policy')" />
    <x-text-input id="privacy" name="privacy_url" type="text" class="mt-1 block w-full" :value="old('privacy_url', config('settings.privacy_url'))" />
    <x-input-error class="mt-2" :messages="$errors->get('privacy_url')" />
</div>
<div>
    <x-input-label for="cookie" :value="__('Cookie Policy')" />
    <x-text-input id="cookie" name="cookie_url" type="text" class="mt-1 block w-full" :value="old('cookie_url', config('settings.cookie_url'))" />
    <x-input-error class="mt-2" :messages="$errors->get('cookie_url')" />
</div>
<div>
    <x-input-label for="ps" :value="__('Playstore URL')" />
    <x-text-input id="ps" name="ps_url" type="text" class="mt-1 block w-full" :value="old('ps_url', config('settings.ps_url'))" />
    <x-input-error class="mt-2" :messages="$errors->get('ps_url')" />
</div>
<div>
    <x-input-label for="as" :value="__('AppStore URL')" />
    <x-text-input id="as" name="as_url" type="text" class="mt-1 block w-full" :value="old('as_url', config('settings.as_url'))" />
    <x-input-error class="mt-2" :messages="$errors->get('as_url')" />
</div>
<div>
    <x-input-label for="i-custom-js" :value="__('Custom JS')" />
    <x-text-area id="i-custom-js" name="custom_js" class="mt-1 block w-full" :value="old('custom_js', config('settings.custom_js'))" />
    <x-input-error class="mt-2" :messages="$errors->get('custom_js')" />
</div>
