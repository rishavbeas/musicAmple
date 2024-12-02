@section('site_title', formatTitle([__('Installation'), config('info.software.name')]))
<form action="{{ route('install.database') }}" method="post">
    @csrf
    <div
        class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Database configuration') }}:</h2>
        @include('shared.message')

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <x-input-label for="i-database-hostname" :value="__('Hostname')" />
                <x-text-input id="i-database-hostname" name="database_hostname" type="text" class="mt-1 block w-full"
                    :value="old('database_hostname', '127.0.0.1')" />
                <x-input-error class="mt-2" :messages="$errors->get('database_hostname')" />
            </div>
            <div class="w-full md:w-1/2 px-3">
                <x-input-label for="i-database-port" :value="__('Port')" />
                <x-text-input id="i-database-port" name="database_port" type="number" class="mt-1 block w-full"
                    :value="old('database_port', '3306')" />
                <x-input-error class="mt-2" :messages="$errors->get('database_port')" />
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <x-input-label for="i-database-name" :value="__('Name')" />
                <x-text-input id="i-database-name" name="database_name" type="text" class="mt-1 block w-full"
                    :value="old('database_name')" />
                <x-input-error class="mt-2" :messages="$errors->get('database_name')" />
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <x-input-label for="i-database-username" :value="__('User')" />
                <x-text-input id="i-database-username" name="database_username" type="text" class="mt-1 block w-full"
                    :value="old('database_username')" />
                <x-input-error class="mt-2" :messages="$errors->get('database_username')" />
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <x-input-label for="i-database-password" :value="__('Password')" />
                <x-text-input id="i-database-password" name="database_password" type="password"
                    class="mt-1 block w-full" :value="old('database_password')" />
                <x-input-error class="mt-2" :messages="$errors->get('database_password')" />
            </div>
        </div>

        <button type="submit"
            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{ __('Next') }}
            @include('icons.chevron-right', [
                'class' => 'w-4 h-4 lg:w-5 lg:h-5 ml-2',
            ])</button>
    </div>
</form>
