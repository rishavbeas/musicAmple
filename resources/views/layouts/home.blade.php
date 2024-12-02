@extends('layouts.wrapper')

@section('body')

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('shared.header')
            <main>
                @yield('content')
            </main>
            @include('shared.footer-home')
        </div>
    </body>
@endsection
