<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
@yield('style')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body id="app-layout">
@include('layouts.partials.navigation')

<div class="container">
    @include('flash::message')
        @yield('content')
    </div>

@include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
@yield('script')
</body>
</html>
