@section('pageTitle', 'Register')
@include('auth.document-top')

        <!-- Start Header -->
        <header>
            <div class="row no-margin-lr header-right">
                <div class="col-md-12">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
            @include('auth.header')
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main class="register-main">
            <div class="row no-margin-lr">
                <div class="top-content text-center">
                    <span>Fill out the form to register</span>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if (isset($_company->subdomain) && $_company->subdomain != "app")
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
                                @else 
                                    @include('auth.multi-step-form')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End Main -->

        <!-- Bottom Content -->
        <div class="register-bottom-wrapper">
            <div class="form-multistep-number"></div>
            <div class="upgrade-wrapper">
                <h4>You've selected the Basic plan at $49.99 per month - <a href="#" class="upgrade-plan">Upgrade to Premium</a></h4>
            </div>
        </div>
        <!-- End Bottom Content -->

<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->
