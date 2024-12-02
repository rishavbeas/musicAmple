@extends('layouts.wrapper')

@section('body')
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
@endsection
