@section('site_title', formatTitle([config('app.name'), $playlist->name]))
@extends('layouts.home')
@section('head_content')
    <meta property="og:title" content="{{ $playlist->name }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $playlist->image ? URL::to('/uploads/playlists/' . $playlist->image) : URL::to('/uploads/playlists/default.png') }}" />
@endsection
@section('content')
    <section class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-8">
                            <div class="gap-6 flex">
                                <img class="w-32 sm:w-48 dark:hidden rounded-xl"
                                    src="{{ $playlist->image ? URL::to('/uploads/playlists/' . $playlist->image) : URL::to('/uploads/playlists/default.png') }}"
                                    alt="{{ $playlist->name }}">
                                <img class="w-32 sm:w-48 h-32 object-cover hidden dark:block rounded-xl"
                                    src="{{ $playlist->image ? URL::to('/uploads/playlists/' . $playlist->image) : URL::to('/uploads/playlists/default.png') }}"
                                    alt="{{ $playlist->name }}">
                                <div class="mt-4 md:mt-0">
                                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                                        {{ $playlist->name }}</h2>
                                    <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">
                                        {{ $playlist->description }}</p>
                                </div>
                            </div>
                            @if (count($trackList) == 0)
                                <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('No results found.') }}</div>
                            @else
                                <div class="flex">
                                    <div class="w-full mt-4 bg-white dark:bg-gray-800 dark:border-gray-700">
                                        <h2
                                            class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                                            {{ __('Track Lists') }}</h2>
                                        <hr class="mx-auto my-4 rounded md:my-4 border-gray-200 dark:border-gray-700">
                                        <div class="flow-root">
                                            <ul role="list"
                                                class="list-decimal px-4 divide-y divide-gray-200 dark:divide-gray-700 align-middle">
                                                @foreach ($trackList as $track)
                                                    @php
                                                        $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
                                                    @endphp
                                                    <li class="py-1 sm:py-2">
                                                        <a href="{{ route('tracks.detail', $track->id) }}">
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
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            @include('playlists.partials.other-playlist')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
