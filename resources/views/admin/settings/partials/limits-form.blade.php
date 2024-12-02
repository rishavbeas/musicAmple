<div>
    <label for="i-search-per-page"
        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('Search Results per page') }}</label>
    <div class="relative mt-2 rounded-md shadow-sm">
        <select name="paginate" id="i-search-per-page"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ([10, 25, 50, 100] as $value)
                <option value="{{ $value }}" @if (request()->input('per_page') == $value ||
                        (request()->input('per_page') == null && $value == config('settings.paginate'))) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <label for="i-app-explorer-per-page"
        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('App · Explorer Item Per Page') }}</label>
    <div class="relative mt-2 rounded-md shadow-sm">
        <select name="e_per_page" id="i-app-explorer-per-page"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ([10, 25, 50, 100] as $value)
                <option value="{{ $value }}" @if (request()->input('per_page') == $value ||
                        (request()->input('per_page') == null && $value == config('settings.e_per_page'))) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <label for="i-app-per-page"
        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('App · Home Results per page (Latest,Popular,Random)') }}</label>
    <div class="relative mt-2 rounded-md shadow-sm">
        <select name="m_per_page" id="i-app-per-page"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ([10, 25, 50, 100] as $value)
                <option value="{{ $value }}" @if (request()->input('per_page') == $value ||
                        (request()->input('per_page') == null && $value == config('settings.m_per_page'))) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <label for="i-m-search-per-page"
        class="block text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ __('App · Search Results per page') }}</label>
    <div class="relative mt-2 rounded-md shadow-sm">
        <select name="s_per_page" id="i-m-search-per-page"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ([10, 25, 50, 100] as $value)
                <option value="{{ $value }}" @if (request()->input('per_page') == $value ||
                        (request()->input('per_page') == null && $value == config('settings.s_per_page'))) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
