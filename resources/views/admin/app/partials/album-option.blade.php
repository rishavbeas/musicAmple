<div>
    <x-input-label for="i-show-album-type" :value="__('Show')" />
    <x-input-select id="i-show-album-type" class="mt-1 block w-full" x-model="albumType" :options="[
        'all' => __('All Album'),
        'custom' => __('Custom'),
    ]"
        :selected="old('albumType')" />
    <x-input-error class="mt-2" :messages="$errors->get('albumType')" />
</div>
