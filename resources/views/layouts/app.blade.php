<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
                            @if (auth()->user())
                            <div class="notifications cols-xs-12" data-id="{{ auth()->user()->id }}" data-token="{{ csrf_token() }}">
                                @foreach ( auth()->user()->unreadNotifications as $notification)
                                <div class="alert alert-success">
                                    <div class="col-md-9 message"><strong>{{ isset($notification['data']['duplicate']) ? "Duplicate" : "New" }}</strong> A referral has been submitted: {{ $notification['data']['first_name'] }} {{ $notification['data']['last_name'] }}</div> <div class="col-md-3 text-right"><button type="submit" class="mark-read"  data-nid="{{ $notification->id }}">Mark as read</button></div>
                                    <div class="clearfix"></div>
                                </div>
                                @endforeach
                            </div>
                            @endif
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
</body>
</html>
