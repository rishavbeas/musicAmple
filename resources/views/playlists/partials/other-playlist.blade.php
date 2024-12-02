@if (count($other_playlist) > 0)
    <h2 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">
        {{ __('Other Playlists') }}</h2>
    <hr class="my-2 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-4">
    <ul class="max-w-md dark:divide-gray-700 mb-4">
        @foreach ($other_playlist as $playlist)
            <li class="py-2 sm:py-2">
                <a href="{{ route('playlists.show', $playlist->id) }}" title="{{ $playlist->name }}">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-12 h-12 rounded-md object-cover"
                                src="{{ $playlist->image ? URL::to('/uploads/playlists/' . $playlist->image) : URL::to('/uploads/playlists/default.png') }}"
                                alt="{{ $playlist->name }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $playlist->name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ realname($playlist->users->username, $playlist->users->first_name, $playlist->users->last_name) }}
                            </p>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif
