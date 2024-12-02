@section('site_title', formatTitle([__('Stats'), $artist->name, config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Stats') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <div class="max-w-xl">
                            <section class="space-y-6" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ formatTitle([__('Statistics'), $artist->name]) }}
                                    </h2>
                                </header>
                                @php
                                    $filter_list = [['route' => route('artists.show', ['id' => $artist->id, 'filter' => 'today']), 'title' => __('Today'), 'value' => 'today'], ['route' => route('artists.show', ['id' => $artist->id, 'filter' => 'last7']), 'title' => __('Last 7 days'), 'value' => 'last7'], ['route' => route('artists.show', ['id' => $artist->id, 'filter' => 'last30']), 'title' => __('Last 30 days'), 'value' => 'last30'], ['route' => route('artists.show', ['id' => $artist->id, 'filter' => 'last356']), 'title' => __('Last 365 days'), 'value' => 'last356'], ['route' => route('artists.show', ['id' => $artist->id, 'filter' => 'total']), 'title' => __('Total'), 'value' => 'total']];
                                @endphp
                                <div class="relative">
                                    <div class="relative sm:overflow-hidden">
                                        <div class="sm:block">
                                            <div class="-mb-px flex space-x-2 overflow-x-auto" aria-label="Tabs">
                                                @foreach ($filter_list as $filter)
                                                    <a href="{{ $filter['route'] }}"
                                                        class="{{ request()->input('filter') == $filter['value'] ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}  whitespace-nowrap flex text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mb-2 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-7000">{{ $filter['title'] }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                                <div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                        <div class="flex">
                                            <header>
                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $play }}
                                                </h2>
                                                <p class="font-normal text-gray-700 dark:text-gray-400">
                                                    {{ __('Plays') }}</p>
                                            </header>
                                        </div>
                                        <div class="flex">
                                            <header>
                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $like }}
                                                </h2>
                                                <p class="font-normal text-gray-700 dark:text-gray-400">
                                                    {{ __('Likes') }}
                                                </p>
                                            </header>
                                        </div>
                                        <div class="flex">
                                            <header>
                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $comment }}
                                                </h2>
                                                <p class="font-normal text-gray-700 dark:text-gray-400">
                                                    {{ __('Comments') }}
                                                </p>
                                            </header>
                                        </div>
                                        <div class="flex">
                                            <header>
                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $download }}
                                                </h2>
                                                <p class="font-normal text-gray-700 dark:text-gray-400">
                                                    {{ __('Downloads') }}</p>
                                            </header>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap text-sm font-medium text-center">
                                        <li @click="openTab = 1"
                                            :class="{ 'border-b-2 border-b-red-500': openTab === 1 }">
                                            <button class="inline-block p-4 rounded-t-lg" type="button"
                                                role="tab">{{ __('Tracks') }}</button>
                                        </li>
                                        <li @click="openTab = 2"
                                            :class="{ 'border-b-2 border-b-red-500': openTab === 2 }">
                                            <button class="inline-block p-4 rounded-t-lg" type="button"
                                                role="tab">{{ __('Users') }}</button>
                                        </li>
                                        <li @click="openTab = 3"
                                            :class="{ 'border-b-2 border-b-red-500': openTab === 3 }">
                                            <button class="inline-block p-4 rounded-t-lg" type="button"
                                                role="tab">{{ __('Location') }}</button>
                                        </li>
                                    </ul>
                                </div>
                                {{-- Track Tab --}}
                                <div x-show="openTab === 1" class="space-y-6">
                                    @include('admin.artists.partials.track-tab')
                                </div>
                                {{-- User Tab --}}
                                <div x-show="openTab === 2" class="space-y-6">
                                    @include('admin.artists.partials.user-tab')
                                </div>
                                {{-- Location Tab --}}
                                <div x-show="openTab === 3" class="space-y-6">
                                    @include('admin.artists.partials.location-tab')
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
