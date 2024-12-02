@section('site_title', formatTitle([__('Update'), config('info.software.name')]))

<div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form action="{{ route('update.overview') }}" method="post">
        @csrf

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body text-center py-5">
                @include('shared.message')

                <div class="my-6">
                    <p class="mb-2 text-xl font-light text-gray-500 sm:text-md dark:text-gray-400">{{ __('Updates pending') }}</p>
                    <p class="mb-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ $updates }}</p>
                </div>
            </div>
        </div>

        <button type="submit"
            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{ __('Next') }}
            @include('icons.chevron-right', [
                'class' => 'w-4 h-4 lg:w-5 lg:h-5 ml-2',
            ])</button>
    </form>
</div>
