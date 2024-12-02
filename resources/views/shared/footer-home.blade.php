<footer class="bg-white dark:bg-gray-800">
    <div class="mx-auto w-full p-4 py-6 lg:py-8 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <x-application-logo />
                    <!--<span class="ml-3 self-center text-2xl font-semibold  dark:text-white">{{ config('app.name') }}</span>-->
                </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">{{ __('Download') }}</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{ config('settings.ps_url') }}" class="hover:underline ">{{ __('Android') }}</a>
                        </li>
                        <li>
                            <a href="{{ config('settings.as_url') }}" class="hover:underline">{{ __('iOS') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                    <ul class="text-gray-500 dark:text-gray-400 font-medium">
                        <li class="mb-4">
                            <a href="{{ config('settings.privacy_url') }}" class="hover:underline">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li>
                            <a href="{{ config('settings.tos_url') }}" class="hover:underline">{{ __('Terms & Conditions') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span
                class="text-sm text-gray-500 sm:text-center dark:text-gray-400">{{ __('© :year :name.', ['year' => now()->year, 'name' => config('app.name')]) }}
                {{ __('All rights reserved.') }}
            </span>
            <div class="flex mt-4 space-x-5 sm:justify-center sm:mt-0">
                @foreach (['facebook' => __('Facebook'), 'twitter' => 'Twitter', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'telegram' => 'Telegram'] as $url => $title)
                @if (config('settings.' . $url))
                <a href="{{ config('settings.'.$url) }}" title="{{ $title }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                    @include('icons.social.'.strtolower($title), ['class' => 'w-4 h-4'])
                    <span class="sr-only">{{ $title }}</span>
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</footer>
