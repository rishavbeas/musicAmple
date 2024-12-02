<footer class="bg-white dark:bg-gray-800">
    <div class="w-full max-w-screen-xl mx-auto p-4 sm:px-6 lg:px-8">
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span
            class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">{{ __('© :year :name.', ['year' => now()->year, 'name' => config('app.name')]) }}
            {{ __('All rights reserved.') }}</span>
    </div>
</footer>
