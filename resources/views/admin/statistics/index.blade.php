@section('site_title', formatTitle([__('Statistics'), config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section>
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('User Registration') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $users_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $users_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $users_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $users_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Tracks & Comments') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $tracks_public }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Public') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $tracks_private}}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Private') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $tracks_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}
                                        </p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Artists') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $artists_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $artists_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $artists_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $artists_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Albums') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $albums_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $albums_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $albums_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $albums_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Playlists') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $playlists_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $playlists_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $playlists_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $playlists_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Productions') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $productions_public }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Public') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $productions_unpublic }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Unpublic') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $productions_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}
                                        </p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Likes') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $likes_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $likes_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $likes_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $likes_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Plays') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $views_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $views_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $views_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $views_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-600">
                        <header>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('Downloads') }}
                            </h2>
                        </header>
                        <div class="mt-2 mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $downloads_today }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Today') }}</p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $downloads_this_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('This Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $downloads_last_month }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Last Month') }}
                                        </p>
                                    </header>
                                </div>
                                <div class="flex">
                                    <header>
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $downloads_total }}
                                        </h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ __('Total') }}</p>
                                    </header>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
