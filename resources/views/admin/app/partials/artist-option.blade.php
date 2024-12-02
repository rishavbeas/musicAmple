<div>
    <x-input-label for="i-show-artist-type" :value="__('Show')" />
    <x-input-select id="i-show-artist-type" class="mt-1 block w-full" x-model="artistType" :options="[
        'all' => __('All Artists'),
        'custom' => __('Custom'),
    ]"
        :selected="old('artistType')" />
    <x-input-error class="mt-2" :messages="$errors->get('artistType')" />
</div>
