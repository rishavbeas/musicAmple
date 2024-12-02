@section('site_title', formatTitle([config('app.name'), $page['name']]))
@extends('layouts.home')

@section('content')
    <section class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl lg:text-3xl tracking-tight font-bold text-gray-900 dark:text-white mb-4">
                        {{ __($page->name) }}</h2>
                    <div class="m-auto">
                        <p class="font-light text-gray-500 sm:text-md dark:text-gray-400">{{ __('Updated at') }}:
                            {{ $page->updated_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }}.
                        </p>
                    </div>
                    <div
                        class="prose prose-img:rounded-xl dark:prose-headings:text-white prose-a:text-blue-600 text-gray-500 dark:text-gray-400 mt-4">
                        {!! __($page->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
