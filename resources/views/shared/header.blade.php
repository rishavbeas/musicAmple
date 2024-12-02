<header>
    <nav class="bg-white border-gray-100 px-4 lg:px-6 py-2.5 dark:bg-gray-800 border-b dark:border-gray-700 fixed top-0 left-0 right-0 z-10">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-7xl lg:px-6">
            <a href="{{ route('home') }}" class="flex items-center">
                <x-application-logo />
            </a>
            <div class="flex items-center lg:order-2">
                @auth
                    <a href="{{ url('/admin/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}"
                        class="font-semibold text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log
                        in</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
