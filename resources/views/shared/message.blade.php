@if (request()->session()->get('success'))
    <div x-transition x-cloak x-show="showSuccess" x-data="{ showSuccess: true }"
        class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
        role="alert">
        <div class="text-sm font-medium">{{ request()->session()->get('success') }}</div>
        <button type="button" @click="showSuccess = false"
            class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700">
            @include('icons.close', [
                'class' => 'w-5 h-5',
            ])
        </button>
    </div>
@endif

@if (request()->session()->get('error'))
    <div x-transition x-cloak x-show="showError" x-data="{ showError: true }"
        class="flex p-4 mb-4 text-red-800 rounded-lg border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-700 dark:border-green-00"
        role="alert">
        <div class="text-sm font-medium">{{ request()->session()->get('error') }}</div>
        <button type="button" @click="showError = false"
            class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700">
            @include('icons.close', [
                'class' => 'w-5 h-5',
            ])
        </button>
    </div>
@endif
