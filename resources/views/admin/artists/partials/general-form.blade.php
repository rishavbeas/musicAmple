<div>
    <x-input-label for="i-name" :value="__('Name')" />
    <x-text-input id="i-name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required
        autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>
<div>
    <x-input-label for="i-country" :value="__('Country')" />
    <x-text-input id="i-country" name="country" type="text" class="mt-1 block w-full" :value="old('country')" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('Country')" />
</div>
<div>
    <x-input-label for="i-city" :value="__('City')" />
    <x-text-input id="i-city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('city')" />
</div>
<div>
    <x-input-label for="i-website" :value="__('Website')" />
    <x-text-input id="i-website" name="website" type="text" class="mt-1 block w-full" :value="old('website')" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('website')" />
</div>
<hr class="border-gray-200 dark:border-gray-700">
<div>
    <x-input-label for="i-description" :value="__('Description')" />
    <x-text-area id="i-description" name="description" class="mt-1 block w-full" :value="old('description')" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>
