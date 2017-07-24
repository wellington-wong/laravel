@extends('layouts.company.app')

@section('pageTitle', $_company->company_name . ' Referral Program')

@section('content')

    <div class="container-fluid company-registration-wrapper">

        <div class="row">
	        <div class="col-md-5 col-md-offset-1 custom-company-registration">
	        	<div class="col-md-6"><img class="img-responsive" src="/{{ isset($_company->logo) ? $_company->logo : 'images/company-placeholder.png' }}" /></div>
	        	<div class="col-md-12 custom-company-text">
	        		{!! isset($_company->subdomain_login_text) ?  : '<strong>Welcome to Our Referral Program</strong><br /><span>Create an account to start submitting referrals and earning rewards.</span>' !!}
	        	</div>
	        	<div class="cta-company-registration col-md-12">
	        		<span>Already a member?</span> <a href="{{ route('login') }}">Sign in</a><br />
	        		<span>Questions?</span> <a href="mailto:admin@perxi.com">Email Us</a>
	        	</div>
	        </div>
	        <div class="company-register-form-wrapper col-md-5">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                      <label for="name">First Name</label>
                      <div>
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                      <label for="name">Last Name</label>
                      <div>
                          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                      <label for="email" class="control-label">E-Mail Address</label>
                      <div>
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
@endsection