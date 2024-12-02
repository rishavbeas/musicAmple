@section('site_title', formatTitle([__('New'), __('Artist'), config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
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
                                {{ __('Artist') }}
                            </h2>
                        </header>
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap text-sm font-medium text-center">
                                <li @click="openTab = 1"
                                    :class="{ 'border-b-2 border-b-red-500': openTab === 1 }">
                                    <button class="inline-block p-4 rounded-t-lg" type="button"
                                        role="tab">{{ __('General') }}</button>
                                </li>
                                <li @click="openTab = 2"
                                    :class="{ 'border-b-2 border-b-red-500': openTab === 2 }">
                                    <button class="inline-block p-4 rounded-t-lg" type="button"
                                        role="tab">{{ __('Social') }}</button>
                                </li>
                            </ul>
                        </div>
                        <form enctype="multipart/form-data" method="post" action="{{ route('artists.new') }}"
                            class="mt-6 space-y-6">
                            @csrf
                            <div class="flex flex-row gap-4">
                                <div class="flex-none w-32">
                                    <div x-data="previewImage()">
                                        <template x-if="imageUrl">
                                            <img class="h-32 w-full rounded-lg object-cover"
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
                                            <x-input-file accept="image/*" class="hidden" id="imageUpload" name="image" x-ref="image"
                                                x-on:change="fileChosen" />
                                        </div>
                                    </div>
                                </div>
                                <div class="grow">
                                    {{-- General Tab --}}
                                    <div x-show="openTab === 1" class="space-y-4">
                                        @include('admin.artists.partials.general-form')
                                    </div>
                                    {{-- Social Tab --}}
                                    <div x-show="openTab === 2" class="space-y-4">
                                        @include('admin.artists.partials.social-form')
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
            imageUrl: "",

            fileChosen(event) {
                this.fileToDataUrl(event, (src) => (this.imageUrl = src));
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
