<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <div class="flex">
        <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-sm font-bold leading-none text-gray-900 dark:text-white">{{ __('Top countries') }}
                </h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="list-decimal px-4">
                    @foreach ($countries as $item)
                    <li class="py-1 sm:py-2">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $item->country }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $item->count }}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="flex">
        <div class="w-full bg-white dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-sm font-bold leading-none text-gray-900 dark:text-white">{{ __('Top cities') }}
                </h5>
            </div>
            <div class="flow-root">
                <ul role="list" class="list-decimal px-4">
                    @foreach ($cities as $item)
                    <li class="py-1 sm:py-2">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $item->city }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $item->count }}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
