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
                    <div class="col-md-9 col-md-offset-2 main-content register-content">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" id="register-form">
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
                                        <label for="password" class="col-md-12 control-label">Password</label>

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
                                        <label class="col-md-12 control-label password-note">*Password must be 8 characters and contain a number and a special character.</label>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary btn-next">
                                                Next
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-6 link-social">
                                            @include('auth.social')
                                        </div>
                                    </div>

                                </form>-->


                                <form id="register-form-multistep" action="#">
                                {{ csrf_field() }}
                                    <div>
                                        <h3>Your Info</h3>

                                        <!-- Step 1 -->
                                        <section>
                                            <div class="form-group-wrapper">
                                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                                                    <label for="name" class="col-md-12 control-label">Your First Name</label>

                                                    <div class="col-md-12">
                                                        <input id="first-name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

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
                                                        <input id="last-name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

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
                                                    <label for="password" class="col-md-12 control-label">Password</label>

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
                                                    <label class="col-md-12 control-label password-note">*Password must be 8 characters and contain a number and a special character.</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </section>
                                        <!-- Step 1 End -->

                                        <!-- Step 2 -->
                                        <h3>Company Info</h3>
                                        <section>

                                            <div class="form-group-wrapper">
                                                <div class="form-group col-md-12">
                                                    <label for="password-confirm" class="col-md-12 control-label">Your Company's Name</label>
                                                    <div class="col-md-12">                                                    
                                                    {{ Form::text('company_name', old('company_name'), array('class' => 'form-control')) }}
                                                    </div>                                                
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Your Company's Phone Number</label>
                                                        {{ Form::text('company_phone', old('company_phone'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Your Company's Contact Email</label>
                                                        {{ Form::text('company_email', old('company_email'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12" >
                                                    <div class="col-md-12" >
                                                        <label>Type of Business</label>
                                                    </div>
                                                    <div class="col-md-12" >
                                                        {{ Form::select('business_type', ['small' => 'Small', 'medium' => 'Medium', 'enterprise' => 'Enterprise'], old('business_type'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Your Company's Address Line 1</label>
                                                        {{ Form::text('company_address_1', old('company_address_1'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Line 2</label>
                                                        {{ Form::text('company_address_2', old('company_address_2'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-9">
                                                    <div class="col-md-12">
                                                        <label>City</label>
                                                        {{ Form::text('company_city', old('company_city'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="col-md-12">
                                                        <label>State</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        @include('forms.states')                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Zip</label>
                                                        {{ Form::text('company_zip', old('company_zip'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="col-md-12">
                                                        <label>Country</label>
                                                        {{ Form::text('company_country', old('company_country'), array('class' => 'form-control')) }}
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                        </section>
                                        <!-- Step 2 End -->

                                        <!-- Step 3 -->
                                        <h3>Form Builder</h3>
                                        <section>

                                        </section>
                                        <!-- Step 3 End -->

                                        <!-- Step 4 -->
                                        <h3>Reward Info</h3>
                                        <section>

                                        </section>
                                        <!-- Step 4 End -->

                                        <!-- Step 5 -->
                                        <h3>Reward Info</h3>
                                        <section>

                                        </section>
                                        <!-- Step 5 End -->

                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- End Main -->

        <div class="register-bottom-wrapper">
            <div class="form-multistep-number"></div>
            <div class="upgrade-wrapper">
                <h4>You've selected the Basic plan at $49.99 per month - <a href="#" class="upgrade-plan">Upgrade to Premium</a></h4>
            </div>
        </div>

<!-- Start Footer -->
@include('auth.footer')
<!-- End Footer -->
