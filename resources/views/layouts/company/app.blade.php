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

                <div class="col-sm-12 main-content company-custom">
                    <div class="panel panel-default fill">
                        <div class="panel-heading top-navbar">

                            <nav class="navbar navbar-default navbar-static-top">
                                <div class="container-fluid">
                                    <div class="col-sm-3 navbar-messages no-padding-lr">
                                        {{ $_company->company_name }} 
                                    </div>
                                    <div class="col-sm-9 no-padding-lr">
                                        <!-- Right Side Of Navbar -->
                                        <ul class="nav navbar-nav navbar-right">
                                            <!-- Authentication Links -->
                                            @if (Auth::guest())
                                                <li><a href="{{ route('login') }}">Login</a></li>
                                                <li><a href="{{ route('register') }}">Register</a></li>
                                            @else
                                                <li class="dropdown pull-left navbar-settings-wrapper">
                                                    Hi {{ Auth::user()->name }} 
                                                    <span class="nav-separator">|</span> <a href="#" class="navbar-settings no-padding" data-toggle="dropdown" data-hover="dropdown">Settings <i class="fa fa-angle-down" aria-hidden="true"></i></a> 
                                                    <ul class="dropdown-menu">
                                                      <li><a href="{{ route('program-options') }}">Program Options</a></li>
                                                      <li><a href="{{ route('manage-account') }}">Manage Account</a></li>
                                                      <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                                                    </ul>
                                                </li>
                                                <li class="logout pull-left">
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">                                    
                                                    </a> 

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <div class="panel-body">
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        @foreach (Session::get('success') as $msg)
                                        <li>{!! $msg !!}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if( !$errors->isEmpty() )
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
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

    @yield('js')

</body>
</html>
