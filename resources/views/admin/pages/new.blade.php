@section('site_title', formatTitle([__('New'), __('Page'), config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New') }}
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
                                <form method="post" action="{{ route('pages.new') }}" class="mt-6 space-y-6">
                                    @csrf

                                    <div>
                                        <x-input-label for="i-name" :value="__('Name')" />
                                        <x-text-input id="i-name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="i-slug" :value="__('Slug')" />
                                        <x-text-input id="i-slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                                    </div>
                                    <div>
                                        <x-input-label for="i-content" :value="__('Content')" />
                                        <x-text-area id="i-content" name="content" class="mt-1 block w-full" :value="old('content')"
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
