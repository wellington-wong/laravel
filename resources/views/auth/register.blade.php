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
    <body>

        <!-- Start Header -->
        <header>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
            <section class="container">
                <div class="row">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <figure class="logo col-md-3"><img src="/images/logo.png" alt=""></figure>
                    <div class="col-md-9" id="app-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right navbar-bottom-right">
                            <li><a href="#">How it Works</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main>
            <div class="row">
                <div class="top-content text-center">
                    <span>Fill out the form to register</span>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Register
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            @include('auth.social')
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End Main -->

        <!-- Start Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-2 footer-list">
                        <h4>Headline 3</h4>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>  
                    <div class="col-md-2 footer-list">
                        <h4>Headline 3</h4>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>         
                    <div class="col-md-2 footer-list">
                        <h4>Headline 3</h4>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>     
                    <div class="col-md-2 footer-list col-md-offset-4">
                        <h4>Headline 3</h4>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div> 
                </div>   
                <div class="row">
                    <div class="middle-content">
                        <span>Some random disclaimer text we may need to put here about something important.</span>
                    </div>
                </div> 
            </div>    
            <div class="row">
                <div class="bottom-content text-center">
                    <span>Copyright Stuffs</span>
                </div>
            </div> 
        </footer>
        <!-- End Footer -->

    </body>
</html>
