@include('auth.document-top')
        <!-- Start Header -->        
        <header>
            <div class="row">
                <div class="col-xs-12 col-md-4 pull-right">
                    <ul class="nav navbar-nav navbar-right navbar-top-right">
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        @include('auth.header')
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main>
            <div class="row">
                <div class="top-content text-center">
                    <span>We need some basic information about you to get started</span>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" id="register-form">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                                        <label for="name" class="col-md-12 control-label">Your First Name</label>

                                        <div class="col-md-12">
                                            <input id="first-name" type="text" class="form-control" name="name" value="{{ old('first_name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-6">
                                        <label for="name" class="col-md-12 control-label text-left">Your Last Name</label>

                                        <div class="col-md-12">
                                            <input id="last-name" type="text" class="form-control" name="name" value="{{ old('last_name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @include('forms.phone', ['phone_label'=>"Phone Number", 'class'=>'col-md-12'])

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                        <label for="email" class="col-md-12 control-label">Your E-Mail</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-12">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                                        <div class="col-md-12">
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
@include('auth.footer')
<!-- End Footer -->
