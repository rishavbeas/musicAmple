@section('site_title', formatTitle([__('Edit'), __('Page'), config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Pages') }}
                                    </h2>
                                </header>
                                @if (session('success'))
                                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="flex p-4 mb-4 mt-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                    role="alert">
                                    @include('icons.check-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
                                    <div class="ml-3 text-sm font-medium">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                                    class="flex p-4 mb-4 mt-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                    role="alert">
                                    @include('icons.information-circle', [
                                        'class' => 'flex-shrink-0 w-5 h-5',
                                    ])
                                    <div class="ml-3 text-sm font-medium">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                                <form method="post" action="{{ route('pages.edit', $page->id) }}" class="mt-6 space-y-6">
                                    @csrf

                                    <div>
                                        <x-input-label for="i-name" :value="__('Name')" />
                                        <x-text-input id="i-name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $page->name)" required autofocus/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="i-slug" :value="__('Slug')" />
                                        <x-text-input id="i-slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $page->slug)"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                                    </div>
                                    <div>
                                        <x-input-label for="i-content" :value="__('Content')" />
                                        <x-text-area id="i-content" name="content" class="mt-1 block w-full" :value="old('content', $page->content)"
                                            autofocus />
                                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
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
