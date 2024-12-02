@section('site_title', formatTitle([__('Edit'), __('Album'), config('app.name')]))
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
                    <section class="space-y-6">
                        <header>
                            @if (session('success'))
                                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                    role="alert">
                                    @include('icons.check-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
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
                                {{ __('Album') }}
                            </h2>
                        </header>
                        @php
                            $production_list = [];
                            foreach ($productions as $key => $value) {
                                $production_list[] = $value['id'] . ',' . $value['slug'] . ',' . $value['name'];
                            }
                        @endphp
                        <form enctype="multipart/form-data" method="post"
                            action="{{ route('albums.edit', $album->id) }}" class="mt-6 space-y-6">
                            @csrf
                            <div class="flex space-x-4">
                                <div class="flex-none w-32">
                                    <div x-data="previewImage()">
                                        <template x-if="imageUrl">
                                            <img class="h-32 w-full rounded-lg object-cover" x-show="imageUrl"
                                                :src="imageUrl">
                                        </template>
                                        <div x-show="!imageUrl"
                                            @click="$refs.image.click()"
                                            class="text-gray-300 flex flex-col items-center w-36 h-36 text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 p-2 text-center rounded-lg border justify-center">
                                            @include('icons.upload', ['class' => 'h-8 w-8'])
                                            <p>{{ __('Image Preview') }}</p>
                                        </div>
                                        <div class="py-4">
                                            <button type="button"
                                                :class="selectedImage ? 'bg-green-300 text-green-800' : 'bg-white'"
                                                class="w-full inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                                                @click="$refs.image.click()"
                                                x-text="selectedImage ? '{{ __('Image Selected') }}' : '{{ __('Upload Image') }}'"></button>
                                            <x-input-file accept="image/*" class="hidden" id="imageUpload" name="image" x-ref="image"
                                                x-on:change="fileChosen" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grow space-y-6">
                                    <div>
                                        <x-input-label for="i-name" :value="__('Name')" />
                                        <x-text-input id="i-name" name="name" type="text"
                                            class="mt-1 block w-full" :value="old('name', $album->name)" required autofocus autocomplete="name"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="i-production" :value="__('Production')" />
                                        <x-input-select-album id="i-production" name="pid" class="mt-1 block w-full"
                                            :options="$production_list" :selected="old('pid', $album->pid)" autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('pid')" />
                                    </div>

                                    <div>
                                        <x-input-label for="i-status" :value="__('Status')" />
                                        <x-input-select id="i-status" name="public" class="mt-1 block w-full"
                                            :options="[2 => __('Unpublic'), 1 => __('Public')]" :selected="old('public', $album->public)" autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('public')" />
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function previewImage() {
        return {
            imageUrl: '',
            selectedImage: false,
            fileChosen(event) {
                this.selectedImage = true
                this.fileToDataUrl(event, (src) => (this.imageUrl = src));
            },
            init() {
                this.imageUrl = "{{ url('/') }}/uploads/covers/albums/{{ $album->image }}"
                this.selectedImage = "{{ $album->image != 'default.png' ? true : false }}"
            },
            fileToDataUrl(event, callback) {
                if (!event.target.files.length) return;

                let file = event.target.files[0],
                    reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = (e) => callback(e.target.result);
            },
        };
    }
</script>
