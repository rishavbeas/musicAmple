@section('site_title', formatTitle([__('Reports'), config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <div class="flex mb-4">
            <div class="w-1/2">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Reports') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <div class="sm:flex sm:items-center sm:justify-between py-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center gap-x-3 py-2">
                        <div class="text-lg font-semibold text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            {{ __('Reports') }}</div>
                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400">
                                {{ request()->session()->get('success') }}</p>
                        @endif
                    </div>
                    <div cclass="flex items-center mt-4 gap-x-3">
                        <label for="table-search" class="sr-only">{{ __('Case ID') }}</label>
                        <form method="GET" action="{{ route('reports') }}">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    @include('icons.search', [
                                        'class' => '"w-5 h-5 text-gray-500 dark:text-gray-400',
                                    ])
                                </div>
                                <input type="text" name="search" value="{{ app('request')->input('search') }}"
                                    class="w-full lg:w-80 md:w-80 sm:w-80  block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ __('Case ID') }}">

                                <div x-data="{ isOpen: false }">
                                    <!-- Dropdown toggle button -->
                                    <button @click="isOpen = !isOpen" type="button"
                                        class="absolute top-0 right-0 p-2 text-sm font-medium text-white rounded-r-lg border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                        @include('icons.filter', [
                                            'class' => '"w-5 h-5 text-gray-500 dark:text-gray-400',
                                        ])
                                    </button>
                                    <template x-if="true">
                                        <!-- Dropdown menu -->
                                        <div x-show="isOpen" @click.away="isOpen = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-90"
                                            class="absolute right-0 z-20 w-80 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                            <!-- Dropdown menu -->

                                            <div class="flex items-center justify-between p-4">
                                                <span
                                                    class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Filter') }}</span>
                                                <a href="{{ route('albums') }}"
                                                    class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
                                                    tabindex="0" role="button">{{ __('Reset') }}</a>
                                            </div>
                                            <hr class="border-gray-200 dark:border-gray-700">
                                            <div class="relative overflow-x-auto sm:rounded-lg max-h-96">
                                                <div class="px-4 py-2">
                                                    <label for="i-sort"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Sort') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="sort" id="i-sort"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach (['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (request()->input('sort') == $key) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <label for="i-per-page"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Results per page') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="per_page" id="i-per-page"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach ([10, 25, 50, 100] as $value)
                                                                <option value="{{ $value }}"
                                                                    @if (request()->input('per_page') == $value ||
                                                                            (request()->input('per_page') == null && $value == config('settings.paginate'))) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-gray-200 dark:border-gray-700">
                                            <div class="px-4 py-2">
                                                <button type="submit"
                                                    class="w-full px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Search') }}</button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (count($reports) == 0)
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('No results found.') }}</div>
                @else
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($reports as $report)
                                @php
                                    if ($report->reason) {
                                        $type = 'Abusive Track';
                                    } else {
                                        $type = 'Copyright Infringement';
                                    }
                                @endphp
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full"
                                                src="{{ url('/') }}/uploads/avatars/{{ $report->users->image }}"
                                                alt="{{ realname($report->users->username, $report->users->first_name, $report->users->last_name) }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ realname($report->users->username, $report->users->first_name, $report->users->last_name) }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $type }}</p>
                                        </div>
                                        <div
                                            class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('reports.show', $report->id) }}"><x-normal-button :value="__('View')"/></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-3 align-items-center">
                        <div class="auto-cols-auto">
                            {{ $reports->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
