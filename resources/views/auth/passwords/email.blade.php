@section('pageTitle', 'Forgot Password')
@include('auth.document-top')
        <!-- Start Header -->
        <header>
        @include('auth.header')
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 main-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="top-content text-center">
                                    <span>Enter your email address to reset the password.</span>                                    
                                </div>
                                <div>&nbsp;</div>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}

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

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Send Password Reset Link
                                            </button>
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
