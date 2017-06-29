<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="env" content="{{ config('app.env') }}" >
    @if ( 'local' == config('app.env') )
        <meta name="robots" content="noindex" >
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle', '') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="logged-in">
    <div id="app" class="fill">

        <div class="container-fluid fill">
            <div class="row fill">

                @if (!Auth::guest())
                <div class="col-sm-3 col-sidebar affix">
                @include('layouts.sidebar')
                </div>
                @endif
                <div class="col-sm-9 page-right main-content">
                    <div class="panel panel-default fill">
                        <div class="panel-heading top-navbar">
                            @include('layouts.navbar')
                        </div>

                        <div class="panel-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Scripts -->

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('/js/all.js') }}"></script>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}

    @yield('js')

</body>
</html>
