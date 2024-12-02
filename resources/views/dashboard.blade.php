@section('site_title', formatTitle([__('Dashboard'), config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <div class="flex mb-4">
            <div class="w-1/2">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="w-1/2 text-right">
                <a href="{{ route('statistics') }}"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">{{ __('Statistics') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:p-2 md:grid-cols-3 gap-4 pb-8 px-4 lg:px-0">
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.users', ['class' => 'w-10 h-10 text-gray-500 dark:text-gray-400'])
                    <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ $users_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Users') }}</p>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg  dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.tracks', [
                        'class' => 'w-10 h-10 mb-4 text-gray-500 dark:text-gray-400',
                    ])

                    <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $tracks_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Tracks') }}</p>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg  dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.playlists', [
                        'class' => 'w-10 h-10 mb-4 text-gray-500 dark:text-gray-400',
                    ])
                        <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $playlists_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Playlists') }}</p>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg  dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.comments', [
                        'class' => 'w-10 h-10 mb-4 text-gray-500 dark:text-gray-400',
                    ])

                    <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $comments_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Comments') }}</p>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg  dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.likes', ['class' => 'w-10 h-10 mb-4 text-gray-500 dark:text-gray-400'])

                    <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $likes_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Likes') }}</p>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg  dark:bg-gray-800 dark:border-gray-700">
                    @include('icons.downloads', [
                        'class' => 'w-10 h-10 mb-4 text-gray-500 dark:text-gray-400',
                    ])

                    <h5 class="py-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $downloads_today }}</h5>

                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ __('Downloads') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
