@section('site_title', formatTitle([config('app.name'), __(config('settings.tagline'))]))
@extends('layouts.home')
@section('head_content')
    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:description" content="{{ config('settings.tagline') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ url('/') }}/uploads/brand/{{ config('settings.logo') ?? 'logo.png' }}" />
@endsection
@section('content')

    <section
        style="background-image: url('../uploads/background.avif');"
        class="bg-center bg-no-repeat bg-gray-700 bg-blend-multiply">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-32 lg:py-36">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                {{ config('app.name') }}</h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">{{ config('settings.tagline') }}
            </p>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-6">
            @include('home.partials.latest')
            @include('home.partials.popular')
            @include('home.partials.listener')
        </div>
    </section>
@endsection
