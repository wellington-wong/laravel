@extends('layouts.company.app')

@section('pageTitle', $_company->company_name . ' Referral Program')

@section('content')

    <div class="container-fluid company-registration-wrapper">

        <div class="row">
	        <div class="col-md-5 col-md-offset-1 custom-company-registration no-padding-l">
	        	<div class="row">
                  <div class="col-md-6"><img class="img-responsive" src="/{{ isset($_company->logo) ? $_company->logo : 'images/company-placeholder.png' }}" /></div>
  	        	
                  <div class="col-md-12 custom-company-text">
          		    {!! isset($_company->subdomain_login_text) ? $_company->subdomain_login_text : '<strong>Welcome to Our Referral Program</strong><br /><span>Create an account to start submitting referrals and earning rewards.</span>' !!}
                  </div>
	        	</div>
	        </div>
	        <div class="company-register-form-wrapper col-md-5">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                  {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                      <label for="first_name">FIRST NAME *</label>
                      <div>
                          <input id="first-name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-6">
                      <label for="last_name">LAST NAME *</label>
                      <div>
                          <input id="last-name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                      <label for="phone" class="control-label">PHONE *</label>
                      <div>
                        <input data-format="(ddd) ddd-dddd" name="phone" value="{{ old('phone') }}" class="bfh-phone form-control" type="text"> 
                        <input name="phone_placeholder" value="{{ old('phone') }}" class="phone-placeholder form-control" style="display: none;" type="text">
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                      <label for="email" class="control-label">EMAIL *</label>
                      <div>
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-address">
                      <div class="form-group col-md-12">
                        <label for="address" class="control-label">ADDRESS LINE 1</label>
                        <input class="form-control" name="address" type="text" value="{{ old('address') }}">
                      </div>

                      <div class="form-group col-md-12">
                        <label for="address2" class="control-label">ADDRESS LINE 2</label>
                          <input class="form-control" name="address2" type="text" value="{{ old('address2') }}">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="city" class="control-label">CITY</label>
                          <input class="form-control" name="city" type="text" value="{{ old('city') }}">
                      </div>

                      <div class="form-group col-md-2 no-padding-lr">
                        <label for="state" class="control-label">STATE</label>
                        <select class="form-control company-register-state" data-value="{{ old('state') }}" name="state"><option value="al">AL</option><option value="ak">AK</option><option value="az">AZ</option><option value="ar">AR</option><option value="ca">CA</option><option value="co">CO</option><option value="ct">CT</option><option value="de">DE</option><option value="fl" selected>FL</option><option value="ga">GA</option><option value="hi">HI</option><option value="id">ID</option><option value="il">IL</option><option value="in">IN</option><option value="ia">IA</option><option value="ks">KS</option><option value="ky">KY</option><option value="la">LA</option><option value="me">ME</option><option value="md">MD</option><option value="ma">MA</option><option value="mi">MI</option><option value="mn">MN</option><option value="ms">MS</option><option value="mo">MO</option><option value="mt">MT</option><option value="ne">NE</option><option value="nv">NV</option><option value="nh">NH</option><option value="nj">NJ</option><option value="nm">NM</option><option value="ny">NY</option><option value="nc">NC</option><option value="nd">ND</option><option value="oh">OH</option><option value="ok">OK</option><option value="or">OR</option><option value="pa">PA</option><option value="ri">RI</option><option value="sc">SC</option><option value="sd">SD</option><option value="tn">TN</option><option value="tx">TX</option><option value="ut">UT</option><option value="vt">VT</option><option value="va">VA</option><option value="wa">WA</option><option value="wv">WV</option><option value="wi">WI</option><option value="wy">WY</option></select></div>

                      <div class="form-group col-md-6">
                          <label for="zip" class="control-label">ZIP CODE</label>
                          <input class="form-control" name="zip" maxlength="5" type="text" value="{{ old('zip') }}">
                      </div>
                  </div>                  

                  <div class="form-group col-md-12">
                    <label for="how-did-you-hear" class="control-label">HOW DID YOU HEAR ABOUT US?</label>
                    <input class="form-control" id="how-did-you-hear" name="how_did_you_hear" value="{{ old('how_did_you_hear') }}" type="text">
                  </div>   

                  <div class="form-group col-md-12">
                    <label for="password" class="control-label">PASSWORD *</label>
                    <input class="form-control" id="password" name="password" type="password">
                  </div>

                  <div class="form-group col-md-12">
                    <label for="password_confirmation" class="control-label">CONFIRM PASSWORD *</label>
                    <input class="form-control" id="password-confirmation" name="password_confirmation" type="password">
                  </div>

                  <div class="form-group col-md-12">
                    <label>
                      <input type="checkbox" name="accept_terms" class="accept-terms">
                      <span>ACCEPT</span> <a href="{{ isset($_company->tos_link) ? $_company->tos_link : route('login') }}" class="terms-link">{{ isset($_company->tos_text) ? $_company->tos_text : 'Terms and Conditions' }}</a>
                    </label>
                  </div>

                  <div class="form-group">
                      <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-register col-md-12" disabled>SUBMIT</button>
                      </div>
                  </div>

              </form>
	        </div>
        </div>
    </div>
@endsection