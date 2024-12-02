<div>
    <x-input-label for="i-show-production-type" :value="__('Show')" />
    <x-input-select id="i-show-production-type" class="mt-1 block w-full" x-model="productionType" :options="[
        'all' => __('All Production'),
        'custom' => __('Custom'),
    ]"
        :selected="old('productionType')" />
    <x-input-error class="mt-2" :messages="$errors->get('productionType')" />
</div>
