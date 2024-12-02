@section('site_title', formatTitle([__('Edit'), __('Widget'), config('app.name')]))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
<x-app-layout>
    <section>
        <x-slot name="header">
            <div class="flex mb-4">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ formatTitle([__('Edit'), __('Widget')]) }}
                    </h2>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <div class="max-w-xl">
                            <section class="space-y-6" x-data="WidgetForm()">
                                <header>
                                    @if (session('success'))
                                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                            role="alert">
                                            @include('icons.check-circle', [
                                                'class' => 'flex-shrink-0 w-5 h-5',
                                            ])
                                            <div class="ml-3 text-sm font-medium">
                                                {{ session('success') }}
                                            </div>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                                            class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                            role="alert">
                                            @include('icons.information-circle', [
                                                'class' => 'flex-shrink-0 w-5 h-5',
                                            ])
                                            <div class="ml-3 text-sm font-medium">
                                                {{ session('error') }}
                                            </div>
                                        </div>
                                    @endif
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Widget') }}
                                    </h2>
                                </header>
                                <form enctype="multipart/form-data" method="post"
                                    action="{{ route('app.edit', $widget->id) }}" class="mt-6 space-y-6">
                                    @csrf

                                    <div>
                                        <x-input-label for="i-title" :value="__('Title')" />
                                        <x-text-input id="i-title" name="title" type="text"
                                            class="mt-1 block w-full" x-model="title" required autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                    </div>
                                    {{-- Show Artist Option --}}
                                    <template x-if="type === 'artists'">
                                        @include('admin.app.partials.artist-option')
                                    </template>
                                    {{-- Select Artists --}}
                                    <template x-if="artistType === 'custom'">
                                        @include('admin.app.partials.artists')
                                    </template>
                                    {{-- Show Album Option --}}
                                    <template x-if="type === 'albums'">
                                        @include('admin.app.partials.album-option')
                                    </template>
                                    {{-- Select Albums --}}
                                    <template x-if="albumType === 'custom'">
                                        @include('admin.app.partials.albums')
                                    </template>
                                    {{-- Show Production Option --}}
                                    <template x-if="type === 'productions'">
                                        @include('admin.app.partials.production-option')
                                    </template>
                                    {{-- Select Production --}}
                                    <template x-if="productionType === 'custom'">
                                        @include('admin.app.partials.productions')
                                    </template>
                                    <template x-if="type === 'banner'">
                                        @include('admin.app.partials.banner')
                                    </template>
                                    <template x-if="type === 'ads'">
                                        @include('admin.app.partials.admob-ads')
                                    </template>
                                    <template x-if="type === 'playlists'">
                                        @include('admin.app.partials.playlists')
                                    </template>
                                    <div>
                                        <x-input-label for="i-status" :value="__('Status')" />
                                        <x-input-select id="i-status" name="public" class="mt-1 block w-full"
                                            :options="[2 => __('Unpublic'), 1 => __('Public')]" x-model="public" autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('public')" />
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
<script>
    function WidgetForm() {
        return {
            type: '',
            search: '',
            artistType: '',
            albumType: '',
            productionType: '',
            selectedItem: '',
            imageUrl: '',
            selectedArt: '',
            selected: {},
            selectedLists: [],
            allItem: [],
            isSelectItem: false,
            showSelector: false,
            isSeletedImage: false,
            title: '',
            link: '',
            public: '',
            //Drag
            draggingIndex: null,
            droppingIndex: null,
            onDrop(event) {
                // rearrange the array by inserting the dropped element
                if (this.draggingIndex !== null && this.droppingIndex !== null) {
                    if (this.draggingIndex < this.droppingIndex) {

                        this.selectedLists = [
                            ...this.selectedLists.slice(0, this.draggingIndex),
                            ...this.selectedLists.slice(this.draggingIndex + 1, this.droppingIndex + 1),
                            this.selectedLists[this.draggingIndex],
                            ...this.selectedLists.slice(this.droppingIndex + 1)
                        ];
                    } else if (this.draggingIndex == this.droppingIndex) {
                        // do nothing if the drag and drop index is the same
                    } else {
                        this.selectedLists = [
                            ...this.selectedLists.slice(0, this.droppingIndex),
                            this.selectedLists[this.draggingIndex],
                            ...this.selectedLists.slice(this.droppingIndex, this.draggingIndex),
                            ...this.selectedLists.slice(this.draggingIndex + 1)
                        ];
                    }
                };
            },
            onDragover(event) {
                event.dataTransfer.dropEffect = "move";
            },
            onDragstart(index) {
                this.draggingIndex = index;
            },
            onDragend() {
                this.draggingIndex = null;
                this.droppingIndex = null;
                this.fireTagsUpdateEvent();
            },
            onDragenter(event, index) {
                event.preventDefault();
                this.droppingIndex = index;

            },
            onDragleave(index) {
                if (index === this.droppingIndex) {
                    this.droppingIndex = null;
                }
            },
            init() {
                this.type = '{{ $widget->type }}'
                this.title = '{{ $widget->title }}'
                this.public = '{{ $widget->public }}'
                //Banner
                if (this.type === 'banner') {
                    this.link = '{{ $link }}'
                    this.imageUrl = '{{ URL::to('/uploads/banners/' . $image) }}'
                }
                //Artist
                if (this.type == 'artists') {
                    this.artistType = '{{ $widget->value }}' !== '' ? 'custom' : 'all'
                    var list = {!! $artistList !!};
                    this.selectedLists = list;
                    if (list.length > 0) {
                        this.isSelectItem = true,
                            list.forEach(item => {
                                this.select(item.id, item.name)
                            })
                    }
                }
                //Album
                if (this.type == 'albums') {
                    this.albumType = '{{ $widget->value }}' !== '' ? 'custom' : 'all'
                    var list = {!! $albumList !!};
                    this.selectedLists = list;
                    if (list.length > 0) {
                        this.isSelectItem = true,
                            list.forEach(item => {
                                this.select(item.id, item.name)
                            })
                    }
                }
                //Playlist
                if (this.type == 'playlists') {
                    var list = {!! $playlistList !!};
                    this.selectedLists = list;
                    if (list.length > 0) {
                        this.isSelectItem = true,
                            list.forEach(item => {
                                this.select(item.id, item.name)
                            })
                    }
                }
                //Productions
                if (this.type == 'productions') {
                    this.productionType = '{{ $widget->value }}' !== '' ? 'custom' : 'all'
                    var list = {!! $productionList !!};
                    this.selectedLists = list;
                    if (list.length > 0) {
                        this.isSelectItem = true,
                            list.forEach(item => {
                                this.select(item.id, item.name)
                            })
                    }
                }
            },
            //Image
            imageChosen(event) {
                art = event.target.files[0]
                this.isSeletedImage = true,
                    this.fileToDataUrl(event, (src) => {
                        this.imageUrl = src
                    });
            },
            fileToDataUrl(event, callback) {
                if (!event.target.files.length) return;
                let file = event.target.files[0],
                    reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => callback(e.target.result);
            },
            clearOpts() {
                this.search = '';
                this.showSelector = false;
                this.allItem = []
            },
            select(id, name) {
                const found = this.selectedLists.some(el => el.id === id);
                var obj = {
                    id: id,
                    name: name
                }
                if (!found) {
                    this.selectedLists.push(obj)
                    this.fireTagsUpdateEvent();
                }
                this.clearOpts();
            },
            fireTagsUpdateEvent() {
                this.$el.dispatchEvent(new CustomEvent('tags-update', {
                    detail: {
                        item: this.selectedLists
                    },
                    bubbles: true,
                }));
                this.selectedItem = JSON.stringify(item)
                //Validate field
                Object.keys(item).length > 0 ? this.isSelectItem = true : this.isSelectItem = false
            },
            remove(id) {
                this.selectedLists.splice(id, 1)
                this.fireTagsUpdateEvent();
            },
            goSearch(type) {
                if (this.search) {
                    var FORM_URL = '';
                    switch (type) {
                        case 1:
                            FORM_URL = '{{ route('app.artists.autocomplete') }}';
                            break;
                        case 2:
                            FORM_URL = '{{ route('app.albums.autocomplete') }}';
                            break;
                        case 3:
                            FORM_URL = '{{ route('app.playlists.autocomplete') }}';
                            break;
                        case 4:
                            FORM_URL = '{{ route('app.productions.autocomplete') }}';
                            break;
                    }
                    axios.get(FORM_URL, {
                            params: {
                                search: this.search
                            }
                        }).then((res) => {
                            this.showSelector = true;
                            this.allItem = res.data
                            console.log(res.data);
                        })
                        .catch((err) => {});
                } else {
                    this.showSelector = false;
                }
            },
        }
    }
</script>
