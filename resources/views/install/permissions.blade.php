@section('site_title', formatTitle([__('Installation'), config('info.software.name')]))

<div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Permissions') }}:</h2>
    <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($results['permissions'] as $type => $files)
            <li class="py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                            {{ __($type) }}
                        </p>
                    </div>
                </div>
            </li>
            @foreach($files as $file => $writable)
                <li class="py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-md font-medium text-gray-500 truncate dark:text-gray-400">
                                {{ $file }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-gray-400">
                            <span class="mr-3">775</span>
                            @if($writable)
                                @include('icons.checkmark', [
                                    'class' => 'text-green-500 dark:text-green-400 w-5 h-5',
                                ])
                            @else
                                @include('icons.close', [
                                    'class' => 'text-red-500 dark:text-red-400 w-5 h-5',
                                ])
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        @endforeach
    </ul>
    @if (isset($results['errors']) == false)
        <a href="{{ route('install.database') }}">
            <button type="button"
                class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{ __('Next') }}
                @include('icons.chevron-right', [
                    'class' => 'w-4 h-4 lg:w-5 lg:h-5 ml-2',
                ])</button>
        </a>
    @endif
</div>
