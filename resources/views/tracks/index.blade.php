@section('site_title', formatTitle([config('app.name'), $track->title]))
@extends('layouts.home')
@php
    $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
@endphp
@section('head_content')
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $track->title }}" />
    <meta property="og:description" content="{{ implode(',', $artist_detail['name']) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ trackCover($track->art, $track->albums->image, $artist_detail['image'][0]) }}" />
@endsection
@section('content')
    <section class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-8">
                            <!-- Main Content -->
                            <div x-data="playaudio()"
                                class="flex flex-col items-center bg-white border border-gray-200 rounded-xl shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 mb-4">
                                <button @keydown.tab="playAndStop" @click="playAndStop" type="button"
                                    class="w-full relative rounded-xl group cursor-pointer focus:outline-none focus:ring focus:ring-[#1F89AE] h-48 md:h-40 md:w-48">
                                    <div class="absolute inset-0 flex items-center justify-center p-8">
                                        <div
                                            class="w-full h-full transition duration-300 ease-in-out bg-cyan-500 filter group-hover:blur-2xl">
                                        </div>
                                    </div>
                                    <img alt="{{ $track->title }}"
                                        class="relative rounded-xl object-cover w-full h-48 md:h-40 md:w-48"
                                        src="{{ trackCover($track->art, $track->albums->image, $artist_detail['image'][0]) }}" />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center transition duration-200 ease-in-out bg-black rounded-xl bg-opacity-30 group-hover:bg-opacity-20">
                                        <div x-show="!currentlyPlaying" class="bg-black bg-opacity-50 rounded-full p-0.5">
                                            @include('icons.play')
                                        </div>
                                        <div x-show="currentlyPlaying" class="bg-black bg-opacity-50 rounded-full p-0.5">
                                            @include('icons.pause')
                                        </div>
                                    </div>
                                </button>
                                <audio x-ref="audio">
                                    <source src="{{ URL::to('/uploads/tracks/' . $track->name) }}" type="audio/mp3" />
                                </audio>
                                <div class="w-full sm:w-full md:w-auto flex flex-col justify-between p-4 leading-normal">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $track->title }}</h5>
                                    <div class="flex space-x-2 mb-2">
                                        @include('icons.person', [
                                            'class' => 'fill-gray-700 text-gray-500 dark:fill-gray-400',
                                        ])
                                        <span class="font-normal text-gray-700 dark:text-gray-400">
                                            {{ implode(',', $artist_detail['name']) }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        @include('icons.album', [
                                            'class' => 'fill-gray-700 text-gray-500 dark:fill-gray-400',
                                        ])
                                        <span
                                            class="font-normal text-gray-700 dark:text-gray-400">{{ $track->albums->name }}</span>
                                    </div>
                                    @if (count($likes) > 0)
                                        <div class="flex -space-x-4">
                                            @foreach ($likes as $like)
                                                @if ($like->users)
                                                    <img class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                                                        src="{{ url('/') }}/uploads/avatars/{{ $like->users->image }}"
                                                        alt="{{ realname($like->users->username, $like->users->first_name, $like->users->last_name) }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if (count($comments) > 0)
                                <h2 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">
                                    {{ __('Comments') }}</h2>
                                <hr class="my-2 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-4">
                                @foreach ($comments as $comment)
                                    <article class="text-base mb-4">
                                        <footer class="flex justify-between items-center mb-2">
                                            <div class="flex items-center">
                                                <p
                                                    class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                                    <img class="mr-2 w-6 h-6 rounded-full"
                                                        src="{{ url('/') }}/uploads/avatars/{{ $comment->users->image }}"
                                                        alt="{{ realname($comment->users->username, $comment->users->first_name, $comment->users->last_name) }}">{{ realname($comment->users->username, $comment->users->first_name, $comment->users->last_name) }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate
                                                        datetime="{{ $comment->created_at }}"
                                                        title="{{ $comment->created_at->tz(config('settings.timezone'))->format(__('F jS, Y')) }}">{{ $comment->created_at->tz(config('settings.timezone'))->format(__('F jS, Y')) }}</time>
                                                </p>
                                            </div>
                                        </footer>
                                        <p class="text-gray-500 dark:text-gray-400">{{ $comment->message }}</p>
                                    </article>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            @include('tracks.partials.recommended')
                            @include('tracks.partials.statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function playaudio() {
            return {
                currentlyPlaying: false,
                //play and stop the audio
                playAndStop() {
                    if (this.currentlyPlaying) {
                        this.$refs.audio.pause();
                        this.$refs.audio.currentTime = 0;
                        this.currentlyPlaying = false;
                    } else {
                        this.$refs.audio.play();
                        this.currentlyPlaying = true;
                    }
                }
            };
        }
    </script>
@endsection
