<div>
    <x-input-label for="i-title" :value="__('Title')" />
    <x-text-input id="i-title" name="title" x-model="formData.title" type="text" class="mt-1 block w-full"
        :value="old('title')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>
<div class="py-2">
    <x-input-label for="i-description" :value="__('Description')" />
    <x-text-area id="i-description" name="description" x-model="formData.description" class="mt-1 block w-full"
        :value="old('description')" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>
<div class="py-2">
    <x-input-label :value="__('Artist')" />
    <div x-data @tags-update="artistId= $event.detail.artistId" data-tags="[]">
        <div class="relative">
            <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md p-2 flex gap-1 flex-wrap mt-2"
                @click="$refs.search_input.focus()" @click.outside="showSelector=false">
                <template x-for="(d, i) in selectArtistList">
                    <div
                        class="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:text-blue-300 dark:border-gray-700 dark:bg-gray-800">
                        <span x-text="d.name"></span>
                        <button @click="remove(i)" type="button"
                            class="inline-flex items-center p-1 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300"
                            aria-label="{{ __('Remove') }}">
                            @include('icons.remove-tag', [
                                'class' => 'w-2 h-2',
                            ])
                            <span class="sr-only">{{ __('Remove') }}</span>
                        </button>
                    </div>
                </template>
                <div class="flex-1">
                    <input type="text" x-model="search" x-ref="search_input" @input.debounce.400ms="goSearch();"
                        placeholder="{{ __('Search') }}" x-bind:required="selectArtist ? false : true"
                        @click.outside="search = ''"
                        class="w-full border-0 focus:border-0 focus:outline-none focus:ring-0 py-1 px-0 dark:bg-gray-900 dark:text-gray-300">
                    <div x-show="showSelector"
                        class="absolute left-0 bg-white z-30 w-full font-medium rounded-b-lg dark:bg-gray-800 mt-1 border border-gray-300 dark:border-gray-700">
                        <div class="space-y-1 overflow-x-auto sm:rounded-lg max-h-96">
                            <template x-for="(name, id) in artistList">
                                <div>
                                    <template x-if="!selected[id]">
                                        <div @click="select(id, name)"
                                            class="dark:text-gray-300 inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            x-text="name"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="Object.keys(artistList).length === 0">
                                <x-input-label class="p-2" :value="__('No result')" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-2">
    <x-input-label for="i-album" :value="__('Album')" />
    <x-input-select-custom id="i-album" x-model="formData.albumId" class="mt-1 block w-full"
        :options="$album_list" autofocus />
</div>
