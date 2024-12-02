<section class="text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User') }}
        </h2>
    </header>
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="flex p-4 mt-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-medium">
                {{ __('Settings saved.') }}
            </div>
        </div>
    @endif
    @if ($user->suspended == 1)
    <div class="flex p-4 mt-4 text-red-800 rounded-lg border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-700 dark:border-green-00"
        role="alert">
        <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
        </svg>
        <div class="ml-3 text-sm font-medium">
            {{ __('This account is currently suspended.') }}
        </div>
    </div>
    @endif
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap text-sm font-medium text-center">
            <li @click="openTab = 1" :class="{ 'border-b-2 border-b-red-500': openTab === 1 }">
                <button class="inline-block p-4 rounded-t-lg" type="button" role="tab">{{ __('General') }}</button>
            </li>
            <li @click="openTab = 2" :class="{ 'border-b-2 border-b-red-500': openTab === 2 }">
                <button class="inline-block p-4 rounded-t-lg" type="button" role="tab">{{ __('Social') }}</button>
            </li>
        </ul>
    </div>
    <form method="post" action="{{ route('users.edit', $user->id) }}" class="mt-6 space-y-6">
        @csrf
        {{-- General Tab --}}
        <div x-show="openTab === 1" class="space-y-6">
            @include('admin.users.partials.general-form')
        </div>
        {{-- Social Tab --}}
        <div x-show="openTab === 2" class="space-y-6">
            @include('admin.users.partials.social-form')
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
