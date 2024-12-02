@section('site_title', formatTitle([__('Update'), config('info.software.name')]))

<div class="p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-5">
        <div class="h-100 flex flex-col justify-center items-center my-6">
            <div class="relative w-32 h-32 flex items-center justify-center">
                <div class="absolute top-0 right-0 bottom-0 left-0 bg-green-500 opacity-10 rounded-full"></div>

                @include('icons.update', ['class' => 'w-16 h-16 text-green-600 dark:text-green-400'])

                <div class="absolute right-0 bottom-0 bg-green-500 w-8 h-8 rounded-full flex items-center justify-center">
                    @include('icons.checkmark', ['class' => 'font-light text-green-100 w-4 h-4'])
                </div>
            </div>

            <div>
                <h5 class="mt-4 text-center font-medium dark:text-white">{{ __('Update') }}</h5>
                <p class="text-center mb-0 dark:text-white">{!! __(':name has been updated.', ['name' => '<span class="font-medium">'.config('info.software.name').'</span>']) !!}</p>
            </div>
        </div>
    </div>
    <a href="{{ route('home') }}">
        <button type="button"
            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{ __('Start') }}
            @include('icons.chevron-right', [
                'class' => 'w-4 h-4 lg:w-5 lg:h-5 ml-2',
            ])</button>
    </a>
</div>
