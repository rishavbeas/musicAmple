@section('site_title', formatTitle([__('Installation'), config('info.software.name')]))

<div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-baseline justify-center">
        <button type="button"
            class="rounded-full text-sm p-2.5 text-center inline-flex items-center bg-green-500 bg-opacity-50">
            @include('icons.arrow-down-on-square', [
                'class' => 'w-16 h-16 text-green-600 dark:text-green-400',
            ])
        </button>
    </div>
    <div class="py-6">
        <h5 class="text-center mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">{{ __('Install') }}</h5>
        <h4 class="text-center mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">{!! __(':name installation wizard.', [
            'name' => '<span class="font-weight-medium">' . config('info.software.name') . '</span>',
        ]) !!}</h4>
    </div>

    <a href="{{ route('install.requirements') }}">
        <button type="button"
            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{ __('Start') }}
            @include('icons.chevron-right', [
                'class' => 'w-4 h-4 lg:w-5 lg:h-5 ml-2',
            ])</button>
    </a>
</div>
