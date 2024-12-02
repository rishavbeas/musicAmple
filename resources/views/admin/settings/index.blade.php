@section('site_title', formatTitle([__('Settings'), config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Settings') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <div class="max-w-xl">
                            @if (session('status') === 'settings-updated')
                                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                    role="alert">
                                    @include('icons.check-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
                                    <div class="ml-3 text-sm font-medium">{{ __('Settings Saved') }}</div>
                                </div>
                            @endif
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
                                            role="tab">{{ __('Limits') }}</button>
                                    </li>
                                    <li @click="openTab = 3"
                                        :class="{ 'border-b-2 border-b-red-500': openTab === 3 }">
                                        <button class="inline-block p-4 rounded-t-lg" type="button"
                                            role="tab">{{ __('Social') }}</button>
                                    </li>
                                    <li @click="openTab = 4"
                                        :class="{ 'border-b-2 border-b-red-500': openTab === 4 }">
                                        <button class="inline-block p-4 rounded-t-lg" type="button"
                                            role="tab">{{ __('Email') }}</button>
                                    </li>
                                    <li @click="openTab = 5"
                                        :class="{ 'border-b-2 border-b-red-500': openTab === 5 }">
                                        <button class="inline-block p-4 rounded-t-lg" type="button"
                                            role="tab">{{ __('Ads') }}</button>
                                    </li>
                                </ul>
                            </div>
                            <form enctype="multipart/form-data" method="post" action="{{ route('settings') }}" class="mt-6 space-y-6">
                                @csrf
                                {{-- General Tab --}}
                                <div x-show="openTab === 1" class="space-y-6">
                                    @include('admin.settings.partials.general-form')
                                </div>
                                {{-- Limit Tab --}}
                                <div x-show="openTab === 2" class="space-y-6">
                                    @include('admin.settings.partials.limits-form')
                                </div>
                                {{-- Social Tab --}}
                                <div x-show="openTab === 3" class="space-y-6">
                                    @include('admin.settings.partials.social-form')
                                </div>
                                {{-- EMail Tab --}}
                                <div x-show="openTab === 4" class="space-y-6">
                                    @include('admin.settings.partials.mail-form')
                                </div>
                                {{-- Ads Tab --}}
                                <div x-show="openTab === 5" class="space-y-6">
                                    @include('admin.settings.partials.ads-form')
                                </div>
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
