<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="custom-company-html">
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
    <link href="https://fonts.googleapis.com/css?family=Domine" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="company-custom-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 main-content company-custom">
                    <div class="panel panel-default">
                        <div class="panel-heading top-navbar">

                            <nav class="navbar navbar-default navbar-static-top">
                                <div class="container-fluid col-md-10 col-md-offset-1">
                                    <div class="col-sm-9 company-name no-padding-lr">
                                        <h4><strong>{{ $_company->company_name }} Referral Program</strong></h4>
                                    </div>
                                    <div class="col-sm-3 company-action no-padding-lr">
                                        <!-- Right Side Of Navbar -->
                                        <ul class="nav navbar-nav navbar-right">
                                            <!-- Authentication Links -->
                                            <li><a class="action" href="{{ Route::is('register') ? route('login') : route('register') }}">{{ Route::is('register') ? 'LOGIN' : 'REGISTER' }}</a></li>
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

    <footer class="footer">
      <div class="container col-md-12 no-padding-lr">
        <div class="col-md-12 cta-footer"><p class="text-center">Want to make your own referral program? Visit <a href="{{ env('APP_URL') }}" class="footer-link-home">perxi.com.</a></p></div>
        <div class="col-md-12 terms-company"><p class="text-center"><a href="{{ env('APP_URL') }}" class="terms-link">Terms and Conditions</a></p></div>
      </div>
    </footer>

    <!-- Scripts -->

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('/js/all.js') }}"></script>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}

    @yield('js')

</body>
</html>
