<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <div class="flex">
        <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-sm font-bold leading-none text-gray-900 dark:text-white">{{ __('Most Played') }}
                </h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($plays as $play)
                        <li class="py-3 sm:py-4">
                            <a href="{{ route('tracks.show', ['id' => $play->id, 'filter' => 'today']) }}"
                                title="{{ $play->title }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-md object-cover"
                                            src="{{ url('/') }}/uploads/tracks/{{ $play->art }}"
                                            alt="{{ $play->title }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $play->title }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $play->count }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="flex">
        <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-sm font-bold leading-none text-gray-900 dark:text-white">{{ __('Most Liked') }}
                </h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($likes as $like)
                        <li class="py-3 sm:py-4">
                            <a href="{{ route('tracks.show', ['id' => $like->id, 'filter' => 'today']) }}"
                                title="{{ $like->title }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-md object-cover"
                                            src="{{ url('/') }}/uploads/tracks/{{ $like->art }}"
                                            alt="{{ $like->title }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $like->title }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $like->count }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="flex">
    <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-sm font-bold leading-none text-gray-900 dark:text-white">{{ __('Most Commented') }}
            </h5>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($comments as $comment)
                    <li class="py-3 sm:py-4">
                        <a href="{{ route('tracks.show', ['id' => $comment->id, 'filter' => 'today']) }}"
                            title="{{ $comment->title }}">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-md object-cover"
                                        src="{{ url('/') }}/uploads/tracks/{{ $comment->art }}"
                                        alt="{{ $comment->title }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $comment->title }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $comment->count }}
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
