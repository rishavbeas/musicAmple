<section>
    <header>
        @if (session('status') === 'general-updated')
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
            {{ __('General information') }}
        </h2>
    </header>

    <form method="post" action="{{ route('artists.general', $artist->id) }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="i-name" :value="__('Name')" />
            <x-text-input id="i-name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $artist->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="i-country" :value="__('Country')" />
            <x-text-input id="i-country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $artist->country)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('Country')" />
        </div>

        <div>
            <x-input-label for="i-city" :value="__('City')" />
            <x-text-input id="i-city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $artist->city)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="i-website" :value="__('Website')" />
            <x-text-input id="i-website" name="website" type="text" class="mt-1 block w-full" :value="old('website', $artist->website)"
                autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('website')" />
        </div>

        <hr class="border-gray-200 dark:border-gray-700">

        <div>
            <x-input-label for="i-description" :value="__('Description')" />
            <x-text-area id="i-description" name="description" class="mt-1 block w-full" :value="old('description', $artist->description)" autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
