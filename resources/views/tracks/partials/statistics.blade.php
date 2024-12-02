<h2 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">
    {{ __('Statistics') }}</h2>
<hr class="my-2 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-4">
<ul class="max-w-md dark:divide-gray-700">
    <li class="pb-3 sm:pb-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-900 truncate dark:text-white uppercase">
                    {{ __('Play today') }}
                </p>
            </div>
            <div class="inline-flex items-center text-xl font-semibold text-red-500">
                {{ $today }}
            </div>
        </div>
    </li>
    <li class="pb-3 sm:pb-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-900 truncate dark:text-white uppercase">
                    {{ __('Play yesterday') }}
                </p>
            </div>
            <div class="inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white">
                {{ $yesterday }}
            </div>
        </div>
    </li>
    <li class="pb-3 sm:pb-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-900 truncate dark:text-white uppercase">
                    {{ __('Play total') }}
                </p>
            </div>
            <div class="inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white">
                {{ $total }}
            </div>
        </div>
    </li>
</ul>
