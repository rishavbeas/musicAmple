@section('site_title', formatTitle([config('app.name'),realname($user->username, $user->first_name, $user->last_name)]))
@extends('layouts.home')
@section('head_content')
    <meta property="og:title" content="{{ realname($user->username, $user->first_name, $user->last_name) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ URL::to('/uploads/avatars/' . $user->image)}}" />
@endsection
@section('content')
    <section class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-8">
                            <div class="gap-6 flex">
                                <div class="px-4 pb-6">
                                    <div class="text-center my-4">
                                        <img class="h-32 w-32 rounded-full mx-auto my-4"
                                            src="{{ URL::to('/uploads/avatars/' . $user->image) }}" alt="{{ realname($user->username, $user->first_name, $user->last_name) }}">
                                        <div class="py-2">
                                            <h3 class="font-bold text-2xl mb-1">{{ realname($user->username, $user->first_name, $user->last_name) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
