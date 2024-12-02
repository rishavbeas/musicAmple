@if (count($recommended) > 0)
    <h2 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">
        {{ __('Recommended') }}</h2>
    <hr class="my-2 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-4">
    <ul class="max-w-md dark:divide-gray-700 mb-4">
        @foreach ($recommended as $track)
            @php
                $artist_art = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
            @endphp
            <li class="py-2 sm:py-2">
                <a href="{{ route('tracks.detail', $track->id) }}" title="{{ $track->title }}">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-12 h-12 rounded-md object-cover"
                                src="{{ trackCover($track->art, $track->albums->image, $artist_art['image'][0]) }}"
                                alt="{{ $track->title }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $track->title }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ implode(',', $artist_art['name']) }}
                            </p>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif
