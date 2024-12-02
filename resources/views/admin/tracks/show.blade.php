@section('site_title', formatTitle([__('Stats'), $track->title, config('app.name')]))
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
                                        {{ formatTitle([__('Statistics'), $track->title]) }}
                                    </h2>
                                </header>
                                @php
                                    $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
                                    $filter_list = [['route' => route('tracks.show', ['id' => $track->id, 'filter' => 'today']), 'title' => __('Today'), 'value' => 'today'], ['route' => route('tracks.show', ['id' => $track->id, 'filter' => 'last7']), 'title' => __('Last 7 days'), 'value' => 'last7'], ['route' => route('tracks.show', ['id' => $track->id, 'filter' => 'last30']), 'title' => __('Last 30 days'), 'value' => 'last30'], ['route' => route('tracks.show', ['id' => $track->id, 'filter' => 'last356']), 'title' => __('Last 365 days'), 'value' => 'last356'], ['route' => route('tracks.show', ['id' => $track->id, 'filter' => 'total']), 'title' => __('Total'), 'value' => 'total']];
                                @endphp
                                <div x-data="playaudio()"
                                    class="flex flex-col items-center bg-white border border-gray-200 rounded-xl shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
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
                                            <div x-show="!currentlyPlaying"
                                                class="bg-black bg-opacity-50 rounded-full p-0.5">
                                                @include('icons.play')
                                            </div>
                                            <div x-show="currentlyPlaying"
                                                class="bg-black bg-opacity-50 rounded-full p-0.5">
                                                @include('icons.pause')
                                            </div>
                                        </div>
                                    </button>
                                    <audio x-ref="audio">
                                        <source src="{{ URL::to('/uploads/tracks/' . $track->name) }}"
                                            type="audio/mp3" />
                                    </audio>
                                    <div
                                        class="w-full sm:w-full md:w-auto flex flex-col justify-between p-4 leading-normal">
                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
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
                                                @foreach ($likes as $user_list)
                                                    @if ($user_list->users)
                                                        <img class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                                                            src="{{ url('/') }}/uploads/avatars/{{ $user_list->users->image }}"
                                                            alt="{{ realname($user_list->users->username, $user_list->users->first_name, $user_list->users->last_name) }}">
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="relative">
                                    <div class="relative sm:overflow-hidden">
                                        <div class="sm:block">
                                            <nav class="-mb-px flex space-x-2 overflow-x-auto" aria-label="Tabs">
                                                @foreach ($filter_list as $filter)
                                                    <a href="{{ $filter['route'] }}"
                                                        class="{{ request()->input('filter') == $filter['value'] ? 'bg-gray-200 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}  whitespace-nowrap flex text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mb-4 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-7000">{{ $filter['title'] }}</a>
                                                @endforeach
                                            </nav>
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
                                                role="tab">{{ __('Users') }}</button>
                                        </li>
                                        <li @click="openTab = 2"
                                            :class="{ 'border-b-2 border-b-red-500': openTab === 2 }">
                                            <button class="inline-block p-4 rounded-t-lg" type="button"
                                                role="tab">{{ __('Location') }}</button>
                                        </li>
                                    </ul>
                                </div>
                                {{-- User Tab --}}
                                <div x-show="openTab === 1" class="space-y-6">
                                    @include('admin.tracks.partials.user-tab')
                                </div>
                                {{-- Location Tab --}}
                                <div x-show="openTab === 2" class="space-y-6">
                                    @include('admin.tracks.partials.location-tab')
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
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
