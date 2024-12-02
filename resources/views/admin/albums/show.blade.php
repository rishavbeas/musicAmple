@section('site_title', formatTitle([__('Album'), $album->name, config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Album') }}
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
                                        {{ formatTitle([__('Album'), $album->name]) }}
                                    </h2>
                                </header>
                                <div
                                    class="flex flex-col items-center bg-white border border-gray-200 rounded-lg md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <img class="object-cover w-full rounded-t-lg h-48 md:h-40 md:w-48 md:rounded-none md:rounded-l-lg"
                                        src="{{ url('/') }}/uploads/covers/albums/{{ $album->image != '' ? $album->image : 'default.png' }}"
                                        alt="{{ $album->name }}">
                                    <div class="flex flex-col justify-between p-4 leading-normal">
                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $album->name }}</h5>
                                        <div class="flex space-x-2 mb-2">
                                            @include('icons.music-note', [
                                                'class' => 'fill-gray-700 text-gray-500 dark:fill-gray-400',
                                            ])
                                            <span class="font-normal text-gray-700 dark:text-gray-400">{{ __(count($tracks).' :song', ['song' => count($tracks) > 1 ? 'Songs' : 'Song']) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if (count($tracks) == 0)
                                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        {{ __('No results found.') }}</div>
                                @else
                                    <div class="flex">
                                        <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex items-center justify-between mb-4">
                                                <h5
                                                    class="text-sm font-bold leading-none text-gray-900 dark:text-white">
                                                    {{ __('Track Lists') }}
                                                </h5>
                                            </div>
                                            <hr
                                                class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-700">
                                            <div class="flow-root">
                                                <ul role="list"
                                                    class="list-decimal px-4 divide-y divide-gray-200 dark:divide-gray-700 align-middle">
                                                    @foreach ($tracks as $track)
                                                        @php
                                                            $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
                                                        @endphp
                                                        <li class="py-1 sm:py-2">
                                                            <div class="flex items-center space-x-4">
                                                                <div class="flex-1 min-w-0">
                                                                    <p
                                                                        class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                                        {{ $track->title }}
                                                                    </p>
                                                                    <p
                                                                        class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                                        {{ implode(',', $artist_detail['name']) }}
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
