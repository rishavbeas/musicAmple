<div>
    <div class="py-4">
        <x-input-label for="i-link" :value="__('Link')" />
        <x-text-input id="i-link" name="link" type="url"
            placeholder="https://example.com" pattern="https://.*" size="30"
            class="mt-1 block w-full" x-model="link" autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('link')" />
    </div>
    <template x-if="imageUrl">
        <img @click="$refs.image.click()" class="w-full h-32 rounded-lg object-cover" x-show="imageUrl"
            :src="imageUrl">
    </template>
    <div x-show="!imageUrl" @click="$refs.image.click()"
        class="text-gray-300 flex flex-col items-center h-32 text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 p-2 text-center rounded-lg border justify-center">
        @include('icons.upload', ['class' => 'h-8 w-8'])
        <p>{{ __('Image Preview') }}</p>
    </div>
    <div class="py-4">
        <button type="button" :class="isSeletedImage ? 'bg-green-300 text-green-800' : 'bg-white'"
            class="justify-center w-40 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
            @click="$refs.image.click()"
            x-text="isSeletedImage ? '{{ __('Image Selected') }}' : '{{ __('Upload Image') }}'"></button>
        <x-input-file accept="image/*" name="image" class="hidden" id="imageUpload" x-model="selectedArt"
            x-ref="image" x-on:change="imageChosen"/>
    </div>
</div>
