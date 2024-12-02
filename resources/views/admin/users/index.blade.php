@section('site_title', formatTitle([__('Users'), config('app.name')]))
<x-app-layout>
    <x-slot name="header">
        <div class="flex mb-4">
            <div class="w-1/2">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Users') }}
                </h2>
            </div>
            <div class="w-1/2 text-right">
                <a href="{{ route('users.create') }}"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">{{ __('New') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <div class="sm:flex sm:items-center sm:justify-between py-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center gap-x-3 py-2">
                        <div class="text-lg font-semibold text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            {{ __('Users') }}</div>
                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400">
                                {{ request()->session()->get('success') }}</p>
                        @endif
                    </div>
                    <div cclass="flex items-center mt-4 gap-x-3">
                        <label for="table-search" class="sr-only">Search</label>
                        <form method="GET" action="{{ route('users') }}">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    @include('icons.search', [
                                        'class' => '"w-5 h-5 text-gray-500 dark:text-gray-400',
                                    ])
                                </div>
                                <input type="text" name="search" value="{{ app('request')->input('search') }}"
                                    class="w-full lg:w-80 md:w-80 sm:w-80  block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ __('Search for users') }}">

                                <div x-data="{ isOpen: false }">
                                    <!-- Dropdown toggle button -->
                                    <button @click="isOpen = !isOpen" type="button"
                                        class="absolute top-0 right-0 p-2 text-sm font-medium text-white rounded-r-lg border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                        @include('icons.filter', [
                                            'class' => '"w-5 h-5 text-gray-500 dark:text-gray-400',
                                        ])
                                    </button>
                                    <template x-if="true">
                                        <!-- Dropdown menu -->
                                        <div x-show="isOpen" @click.away="isOpen = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-90"
                                            class="absolute right-0 z-20 w-80 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                            <!-- Dropdown menu -->

                                            <div class="flex items-center justify-between p-4">
                                                <span
                                                    class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Filter') }}</span>
                                                <a href="{{ route('users') }}"
                                                    class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
                                                    tabindex="0" role="button">{{ __('Reset') }}</a>
                                            </div>
                                            <hr class="border-gray-200 dark:border-gray-700">
                                            <div class="relative overflow-x-auto sm:rounded-lg max-h-96">
                                                <div class="px-4 py-2">
                                                    <label for="i-search-by"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Search by') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="search_by" id="i-search-by"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach (['name' => __('Name'), 'email' => __('Email')] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (request()->input('search_by') == $key || (!request()->input('search_by') && $key == 'name')) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <label for="i-role"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Role') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="role" id="i-role"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            <option value="">{{ __('All') }}</option>
                                                            @foreach ([0 => __('User'), 1 => __('Admin')] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (request()->input('role') == $key && request()->input('role') !== null) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <label for="i-sort-by"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Sort by') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="sort_by" id="i-sort-by"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach (['id' => __('Date created'), 'name' => __('Name'), 'email' => __('Email')] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (request()->input('sort_by') == $key) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <label for="i-sort"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Sort') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="sort" id="i-sort"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach (['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                                                <option value="{{ $key }}"
                                                                    @if (request()->input('sort') == $key) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2">
                                                    <label for="i-per-page"
                                                        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Results per page') }}</label>
                                                    <div class="relative mt-2 rounded-md shadow-sm">
                                                        <select name="per_page" id="i-per-page"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach ([10, 25, 50, 100] as $value)
                                                                <option value="{{ $value }}"
                                                                    @if (request()->input('per_page') == $value ||
                                                                            (request()->input('per_page') == null && $value == config('settings.paginate'))) selected @endif>
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-gray-200 dark:border-gray-700">
                                            <div class="px-4 py-2">
                                                <button type="submit"
                                                    class="w-full px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Search') }}</button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (count($users) == 0)
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('No results found.') }}</div>
                @else
                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="flex items-center px-6 py-4 text-gray-900  dark:text-white w-64">
                                            <a href="{{ route('users.edit', $user->id) }}" class="flex">
                                                <img class="w-10 h-10 rounded-full object-cover"
                                                    src="{{ url('/') }}/uploads/avatars/{{ $user->image }}"
                                                    alt={{ realname($user->username, $user->first_name, $user->last_name) }}>
                                                <div class="pl-3">
                                                    <div class="text-base font-semibold">
                                                        {{ realname($user->username, $user->first_name, $user->last_name) }}
                                                    </div>
                                                    <div class="font-normal text-gray-500">{{ $user->username }}</div>
                                                </div>
                                            </a>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ Auth::user()->role == 2 ? '[hidden]' : $user->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-2.5 w-2.5 rounded-full {{ $user->suspended ? 'bg-red-500' : 'bg-green-500' }} mr-2">
                                                </div>
                                                @if ($user->suspended)
                                                    {{ __('Suspended') }}
                                                @else
                                                    {{ __('Active') }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="sm:flex sm:items-center sm:ml-6">
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                            @include('icons.vertical', [
                                                                'class' => 'w-5 h-5',
                                                            ])
                                                        </button>

                                                    </x-slot>

                                                    <x-slot name="content">
                                                        <x-dropdown-link :href="route('users.edit', $user->id)" class="flex">
                                                            @include('icons.edit', ['class' => 'w-5 h-5'])
                                                            <span class="mx-1">
                                                                {{ __('Edit') }}
                                                            </span>
                                                        </x-dropdown-link>
                                                        <hr class="border-gray-200 dark:border-gray-600">
                                                        <x-dropdown-link href="#" class="flex"
                                                            x-on:click.prevent="$dispatch('open-modal', { name: 'modal-action', url: '{{ route($user->suspended == 0 ? 'users.suspend' : 'users.restore', $user->id) }}' , title: '{{ __($user->suspended == 0 ? 'Are you sure you want to suspend :name ?' : 'Restore :name ?', ['name' => realname($user->username, $user->first_name, $user->last_name)]) }}' , subTitle : '{{ $user->suspended == 0 ? __('Suspending an account will restrict the access to the account and hide its content. It can be fully restored.') : __('Restoring account will restore access to the account and its content.') }}', action: '{{ $user->suspended == 0 ? __('Suspend') : 'Restore' }}' })">
                                                            @include('icons.suspended', [
                                                                'class' => 'w-5 h-5 stroke-red-500',
                                                            ])
                                                            <span class="mx-1 text-red-500">
                                                                {{ $user->suspended == 0 ? 'Suspend' : 'Restore' }}
                                                            </span>
                                                        </x-dropdown-link>
                                                        <x-dropdown-link href="#" class="flex"
                                                            x-on:click.prevent="$dispatch('open-modal', { name: 'modal-action', url: '{{ route('users.destroy', $user->id) }}' , title: '{{ realname($user->username, $user->first_name, $user->last_name) }}' , subTitle : '{{ __('Deleting an account will delete all informations from the server and the action cannot be reverted.') }}', action: '{{ __('Delete') }}' })">
                                                            @include('icons.delete', [
                                                                'class' => 'w-5 h-5 stroke-red-500',
                                                            ])
                                                            <span class="mx-1 text-red-500">
                                                                {{ __('Delete') }}
                                                            </span>
                                                        </x-dropdown-link>
                                                    </x-slot>
                                                </x-dropdown>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 align-items-center">
                        <div class="auto-cols-auto">
                            {{ $users->onEachSide(1)->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Action  -->
    <x-modal-action name="modal-action">
        <form method="post" x-bind:action="url" class="p-6">
            @csrf
            @method('post')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="title"></h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="subTitle"></p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" x-text="action"></x-danger-button>
            </div>
        </form>
    </x-modal-action>
    {{-- <!-- Restore Account -->
    <x-modal name="confirm-user-restore">
        <form method="post" action="{{ route('users.restore',2) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Restore') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Restoring account will restore access to the account and its content.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Restore') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <!-- Delete Account -->
    <x-modal name="confirm-user-delete">
        <form method="post" action="{{ route('users.destroy',2) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Delete') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Deleting an account will delete all informations from the server and the action cannot be reverted.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal> --}}
</x-app-layout>
