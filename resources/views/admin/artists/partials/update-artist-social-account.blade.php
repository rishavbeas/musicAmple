<section>
    <header>
        @if (session('status') === 'social-updated')
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ __('Settings saved.') }}
                </div>
            </div>
        @endif

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Social accounts') }}
        </h2>
    </header>

    <form method="post" action="{{ route('artists.social', $artist->id) }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="i-facebook" :value="__('Facebook')" />
            <x-text-input id="i-facebook" name="facebook" type="text" class="mt-1 block w-full" :value="old('facebook', $artist->facebook)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
        </div>

        <div>
            <x-input-label for="i-twitter" :value="__('Twitter')" />
            <x-text-input id="i-twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $artist->twitter)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
        </div>

        <div>
            <x-input-label for="i-instagram" :value="__('Instagram')" />
            <x-text-input id="i-instagram" name="instagram" type="text" class="mt-1 block w-full"
                :value="old('instagram', $artist->instagram)" autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
        </div>

        <div>
            <x-input-label for="i-youtube" :value="__('Youtube')" />
            <x-text-input id="i-youtube" name="youtube" type="text" class="mt-1 block w-full" :value="old('youtube', $artist->youtube)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('youtube')" />
        </div>

        <div>
            <x-input-label for="i-telegram" :value="__('Telegram')" />
            <x-text-input id="i-telegram" name="telegram" type="text" class="mt-1 block w-full" :value="old('telegram', $artist->telegram)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('telegram')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
