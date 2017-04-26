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
        <header>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
            <section class="container">
                <div>
                    <figure class="logo col-md-3"><img src="/images/logo.png" alt=""></figure>
                    <div class="col-md-9">
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
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Login</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

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
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
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
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <h3>Headline 3</h3>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>  
                    <div class="col-md-2">
                        <h3>Headline 3</h3>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>         
                    <div class="col-md-2">
                        <h3>Headline 3</h3>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div>     
                    <div class="col-md-6 text-right">
                        <h3>Headline 3</h3>
                        <ul>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                            <li><a href="#">List Item in Footer</a></li>
                        </ul>
                    </div> 
                </div>    
            </div>    
        </footer>
    </body>
</html>
