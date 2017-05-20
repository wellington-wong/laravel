@extends('layouts.app')

@section('content')

    @if( !$errors->isEmpty() )
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

	<div class="container-fluid">
		<div class="page-header">
		    <div class="row">
			    <div class="col-md-12">
					<h3>Submit Referral on Behalf of Member</h3>
				</div>
			</div>
		</div>

	    <div class="row">
		    <div class="col-md-12 referral-create-form-wrapper">
			    {{ Form::open(['route'=>'post-referral-create', 'id' => 'referral-create-form']) }}

			    <input type="hidden" name="subdomain_id" value="" >

			    <div class="form-group col-md-12">
			        {{ Form::text('member', old('member'), ['placeholder' => 'Member\'s Name', 'class' => 'form-control']) }}
					{{ Form::hidden('member_id', old('member_id'), ['id' => 'member-id']) }}
			    </div>

			    <div class="form-group col-md-6">
			        {{ Form::text('first_name', null , ['placeholder' => 'Referral\'s First Name', 'class' => 'form-control']) }}
			    </div>

			    <div class="form-group col-md-6">
			        {{ Form::text('last_name', null, ['placeholder' => 'Referral\'s Last Name', 'class' => 'form-control']) }}
			    </div>

			    @include('forms.phone', ['phone_label'=>'Referral\'s Phone Number', 'placeholder' => 'Referral\'s Phone Number'])

			    <div class="form-group col-md-6">
			        {{ Form::text('email', old('email'), ['placeholder' => 'Referral\'s Email', 'class' => 'form-control referral-email']) }}
			    </div>

			    @include('forms.address')

			    <div class="form-group col-md-12" >
			        {{ Form::select('install_complete', ['' => 'Was your friend\'s new AC installation already complete?', 'yes' => 'Yes', 'no' => 'No'], old('install_complete'), ['class' => 'form-control install-complete']) }}
			    </div>

		          <div class="form-group col-md-12 terms-wrapper">
		              <input type="checkbox" name="terms[]" class="terms-acceptance pull-left" @if(count($errors)) checked="checked" @endif>
		              <div class="terms-details">
		                  I understand that the receipt of the $100.00 Cash Reward is dependent on my referral's AC installation Status.
		                  I am only entitled for a Referral Reward if/when this referral's AC Unit has been installed by All Year Cooling and Heating, Inc.
		                  View our full <a href="#" class="terms-condition-link">terms and conditions</a>.
		              </div>
		          </div>

				  <div class="form-group col-md-12 text-center">
				      <button type="submit" class="terms-button btn btn-primary button-responsive-100 submit-referral">Submit Referral</button>
				  </div>
				  
			    {{ Form::close() }}
			</div>
		</div>
	</div>

@include('layouts.modal')

@endsection