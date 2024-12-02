<div>
    <x-input-label :value="__('Playlists')" />
    <div x-data @tags-update="item= $event.detail.item" data-tags="[]">
        <input type="hidden" x-model="selectedItem" name="playlists" />
        <div class="relative">
            <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md p-2 flex gap-1 flex-wrap mt-2"
                @click="$refs.search_input.focus()" @click.outside="showSelector=false">
                <div class="flex-1">
                    <input type="text" x-model="search" x-ref="search_input" @input.debounce.400ms="goSearch(3);"
                        placeholder="{{ __('Search') }}" x-bind:required="isSelectItem ? false : true"
                        @click.outside="search = ''"
                        class="w-full border-0 focus:border-0 focus:outline-none focus:ring-0 py-1 px-0 dark:bg-gray-900 dark:text-gray-300">
                    <div x-show="showSelector"
                        class="absolute left-0 bg-white z-30 w-full font-medium rounded-b-lg dark:bg-gray-800 mt-1 border border-gray-300 dark:border-gray-700">
                        <div class="space-y-1 overflow-x-auto sm:rounded-lg max-h-40">
                            <template x-for="(playlist, id) in allItem">
                                <div>
                                    <template x-if="!selected[id]">
                                        <div @click="select(playlist.id, playlist.value)"
                                            class="dark:text-gray-300 inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            x-text="playlist.value"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="Object.keys(allItem).length === 0">
                                <x-input-label class="p-2" :value="__('No result')" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div @drop.prevent='onDrop($event)' @dragover.prevent='onDragover($event)'>
                <template x-for="(d, index) in selectedLists" :key='index'>
                    <div draggable="true" @dragstart='onDragstart(index)' @dragend='onDragend()'
                        :class="{
                            'opacity-25': draggingIndex === index,
                            'pt-20': droppingIndex == index && draggingIndex >
                                index,
                            'pb-20': droppingIndex == index && draggingIndex < index
                        }"
                        class="flex flex-row relative cursor-move transition-spacing duration-300 ease-in-out mt-4">
                        <div
                            class="p-2.5 text-sm font-medium text-blue-800 bg-blue-100 rounded dark:text-blue-300 dark:border-gray-700 dark:bg-gray-700 w-full flex">
                            <div class="flex-shrink-0">
                                @include('icons.menu', [
                                    'class' => 'w-5 h-5',
                                ])
                            </div>
                            <div class="grow ml-3"><span x-text="d.name"></span></div>
                            <button @click="remove(index)" type="button"
                                class="inline-flex items-center p-1 ml-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300"
                                aria-label="{{ __('Remove') }}">
                                @include('icons.remove-tag', [
                                    'class' => 'w-2 h-2',
                                ])
                                <span class="sr-only">{{ __('Remove') }}</span>
                            </button>
                        </div>

                        <div class="absolute inset-0 opacity-60 cursor-move transition-spacing duration-300 ease-in-out z-10"
                            x-show.transition="draggingIndex !== null" @dragenter.prevent="onDragenter(event, index)"
                            @dragleave="onDragleave">
                        </div>

                        <div :class="{
                            'h-20 top-0 bg-gray-300': droppingIndex === index && draggingIndex >
                                index,
                            'h-20 bottom-0 bg-gray-300': droppingIndex === index && draggingIndex < index
                        }"
                            class="absolute h-0 w-full bg-gray-300 transition-spacing duration-300 ease-in-out opacity-50">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
