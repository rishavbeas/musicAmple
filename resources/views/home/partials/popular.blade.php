<h2 class="text-2xl lg:text-3xl tracking-tight font-bold text-gray-900 dark:text-white mb-4">Popular</h2>
<div class="grid lg:grid-cols-1 gap-4 py-4 lg:py-4">
    @if (count($popular) == 0)
        <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('No results found.') }}</div>
    @else
        <div class="grid grid-cols-4 gap-2 md:grid-cols-8 md:gap-4">
            @foreach ($popular as $track)
                @php
                    $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
                @endphp
                <div class="relative max-w-xs overflow-hidden bg-cover bg-no-repeat">
                    <img class="h-20 max-w-full object-cover rounded-md lg:h-32 w-full"
                        src="{{ trackCover($track->art, $track->album_cover, $artist_detail['image'][0]) }}"
                        alt="{{ $track->title }}">
                    <a href="{{ route('tracks.detail', $track->id) }}">
                        <div
                            class="absolute flex justify-center items-center m-auto bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-[hsl(0,0%,98.4%,0.2)] bg-fixed opacity-0 transition duration-300 ease-in-out hover:opacity-100">
                            @include('icons.play-hover', [
                                'class' => 'w-12 h-12 mx-auto text-green-500 dark:text-red-500',
                            ])
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
<hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
