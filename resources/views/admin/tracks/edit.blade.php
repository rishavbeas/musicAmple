@section('site_title', formatTitle([__('Edit'), $track->title, config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section x-data="UploadForm()" class="space-y-6 text-gray-900 dark:text-gray-100">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 cursor-default">
                                {{ __('Track') }}
                            </h2>
                        </header>
                        @php
                            $album_list = [];
                            foreach ($albums as $key => $value) {
                                if ($value['id'] == $track->album_id) {
                                    $selectedAlbum = $value->id . ',' . $value->slug . ',' . $value->folder;
                                }
                                $album_list[] = $value->id . ',' . $value->slug . ',' . $value->name. ',' . $value->folder;
                            }
                        @endphp
                        <template x-if="uploadSuccess">
                            <div x-transition x-init="setTimeout(() => uploadSuccess = false, 6000)"
                                class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                role="alert">
                                @include('icons.check-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
                                <div class="ml-3 text-sm font-medium" x-html="message"></div>
                            </div>
                        </template>
                        <template x-if="uploadFailed">
                            <div x-show="uploadFailed" x-transition x-init="setTimeout(() => uploadFailed = false, 5000)"
                                class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                role="alert">
                                @include('icons.information-circle', [
                                    'class' => 'flex-shrink-0 w-5 h-5',
                                ])
                                <div class="ml-3 text-sm font-medium" x-text="message"></div>
                            </div>
                        </template>
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap text-sm font-medium text-center">
                                <li @click="openTab = 1" :class="{ 'border-b-2 border-b-red-500': openTab === 1 }">
                                    <button class="inline-block p-4 rounded-t-lg" type="button"
                                        role="tab">{{ __('General') }}</button>
                                </li>
                                <li @click="openTab = 2" :class="{ 'border-b-2 border-b-red-500': openTab === 2 }">
                                    <button class="inline-block p-4 rounded-t-lg" type="button"
                                        role="tab">{{ __('Permission') }}</button>
                                </li>
                            </ul>
                        </div>
                        <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                            <div class="flex flex-row gap-4">
                                <div class="w-32 flex-none ">
                                    <template x-if="imageUrl">
                                        <img class="w-full h-32 rounded-lg object-cover" x-show="imageUrl"
                                            :src="imageUrl">
                                    </template>
                                    <div x-show="!imageUrl"
                                        class="text-gray-300 flex flex-col items-center h-32 text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 p-2 text-center rounded-lg border justify-center">
                                        @include('icons.upload', ['class' => 'h-8 w-8'])
                                        <p>{{ __('Image Preview') }}</p>
                                    </div>
                                    <div class="py-4">
                                        <button type="button"
                                            :class="imageUrl ? 'bg-green-300 text-green-800' : 'bg-white'"
                                            class="w-full inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                                            @click="$refs.image.click()"
                                            x-text="imageUrl ? '{{ __('Image Selected') }}' : '{{ __('Upload Image') }}'"></button>
                                        <button type="button"
                                            :class="lyric ? 'bg-green-300 text-green-800' : 'bg-white'"
                                            class="w-full inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2"
                                            @click="$refs.lyric.click()"
                                            x-text="lyric ? '{{ __('Lyric Selected') }}' : '{{ __('Upload Lyric') }}'"></button>
                                        <button type="button"
                                            :class="track ? 'bg-green-300 text-green-800' : 'bg-white'"class="w-full inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2"
                                            @click="$refs.track.click()"
                                            x-text="track ? '{{ __('Track Selected') }}' : '{{ __('Upload Track') }}'"></button>
                                        <x-input-file accept="image/*" class="hidden" id="imageUpload"
                                            x-model="selectedArt" x-ref="image" x-on:change="imageChosen" />
                                        <x-input-file accept=".lrc" class="hidden" name="lyric"
                                            x-model="selectedLyric" x-ref="lyric" x-on:change="lyricChosen" />
                                        <x-input-file accept="audio/*" class="hidden" name="track"
                                            x-model="selectedTrack" x-ref="track" x-on:change="trackChosen" />
                                    </div>
                                </div>
                                <div class="grow">
                                    {{-- General Tab --}}
                                    <div x-show="openTab === 1" class="space-y-4">
                                        @include('admin.tracks.partials.general-form')
                                    </div>
                                    {{-- Social Tab --}}
                                    <div x-show="openTab === 2" class="space-y-4">
                                        @include('admin.tracks.partials.permission-form')
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">
                            <template x-if="loading">
                                <div>
                                    <label
                                        class="block font-bold text-sm text-gray-700 dark:text-gray-300 uppercase mb-1"
                                        x-text="`Uploading ${width}%`"></label>
                                    <div class="bg-gray-200 rounded h-1" role="progressbar" :aria-valuenow="width"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <div class="bg-green-400 rounded h-1 text-center"
                                            :style="`width: ${width}%; transition: width 1s;`">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="flex items-center gap-4">
                                <x-primary-button x-bind:disabled="loading ? true : false"
                                    x-text="loading ? '{{ __('Processing') }}' : '{{ __('Save') }}'">
                                </x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const FORM_URL = '{{ route('tracks.edit', $track->id) }}';
    let artistId = [];
    let art = '';

    function UploadForm() {
        return {
            openTab: 1,
            activeClasses: 'border-l border-t border-r rounded-t text-blue-700',
            inactiveClasses: 'text-blue-500 hover:text-blue-700',
            image: '',
            imageUrl: '',
            lyric: '',
            track: '',
            search: '',
            selectedArt: '',
            selectedTrack: '',
            selectedLyric: '',
            showSelector: false,
            selectArtist: false,
            selectedImage:false,
            selected: {},
            artistList: [],
            selectArtistList: [],
            //Edit value
            init() {
                this.formData.title = '{{ $track->title }}'
                this.formData.description = '{{ $track->description }}'
                this.formData.public = '{{ $track->public }}'
                this.formData.download = '{{ $track->download }}'
                this.formData.albumId = '{{ $selectedAlbum }}'
                this.imageUrl = '{{ $track->art != 'default.png' ? URL::to('/uploads/tracks/' . $track->art) : '' }}'
                this.artistList = {!! $artists !!}
                let artistId = '{{ $track->artist_id }}'
                let arr_artist = artistId.split(',');
                arr_artist.forEach(id => {
                    var artist = {
                        id: id,
                        name: this.artistList[id]
                    }
                    this.selectArtistList.push(artist)
                    this.fireTagsUpdateEvent();
                })
                this.formData.artistId = this.selectArtistList
                this.selectArtist = true

            },
            //Image
            imageChosen(event) {
                art = event.target.files[0]
                this.selectedImage = true;
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
            //Lyric
            lyricChosen(event) {
                this.lyric = event.target.files[0]
            },
            //Track
            trackChosen(event) {
                this.track = event.target.files[0]
            },
            //Artists
            clearOpts() {
                this.search = '';
                this.showSelector = false;
                this.artistList = []
            },
            select(id, name) {
                const found = this.selectArtistList.some(el => el.id === id);
                var artist = {
                    id: id,
                    name: name
                }
                if (!found) {
                    this.selectArtistList.push(artist)
                    this.fireTagsUpdateEvent();
                }
                this.clearOpts();
            },
            fireTagsUpdateEvent() {
                this.$el.dispatchEvent(new CustomEvent('tags-update', {
                    detail: {
                        artistId: this.selectArtistList
                    },
                    bubbles: true,
                }));
                //Validate field artists
                Object.keys(artistId).length > 0 ? this.selectArtist = true : this.selectArtist = false
            },
            remove(id) {
                this.selectArtistList.splice(id, 1)
                this.fireTagsUpdateEvent();
            },
            goSearch() {
                if (this.search) {
                    this.artistList = {!! $artists !!};
                    this.showSelector = true;
                    this.artistList = Object.keys(this.artistList)
                        .filter((key) => this.artistList[key].toLowerCase().includes(this.search))
                        .reduce((obj, key) => {
                            return Object.assign(obj, {
                                [key]: this.artistList[key]
                            });
                        }, {});
                } else {
                    this.showSelector = false;
                }
            },
            //Form
            formData: {
                title: "",
                description: "",
                albumId: null,
                download: "",
                public: "",
                artistId: [],
            },
            message: "",
            width: 0,
            uploadSuccess: false,
            uploadFailed: false,
            loading: false,
            submitForm() {
                this.message = ""
                this.uploadFailed = false
                this.uploadSuccess = false
                this.loading = true
                const data = new FormData()
                data.append('art', art)
                data.append('lyric', this.lyric)
                data.append('track', this.track)
                data.append('data', JSON.stringify(this.formData))
                //Progressbar
                const config = {
                    onUploadProgress: (progressEvent) => {
                        const percentCompleted = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                        this.width = percentCompleted
                    }
                };
                axios.post(FORM_URL, data, config).then((res) => {
                        if (res.status == 200) {
                            this.uploadSuccess = true
                            this.loading = false
                            this.message = "Track has been successfully updated"
                            this.selectedImage = false
                        }
                    })
                    .catch((err) => {
                        this.width = 0
                        this.loading = false
                        this.uploadFailed = true
                        this.message = err.response.statusText
                    });
            }
        };
    }
</script>
