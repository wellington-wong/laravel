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
	    <div class="row">
		    <div class="col-md-12">
				<h2>Submit Referral on Behalf of Member</h2>
			</div>
		</div>
		
	    <div class="row">
		    <div class="col-md-12">
			    {{ Form::open(['route'=>'post-referral-create', 'id' => 'referral-create-form']) }}

			    <input type="hidden" name="subdomain_id" value="" >

			    <div class="form-group" >
			        <label>Referral's First Name</label>
			        {{ Form::text('first_name') }}
			    </div>

			    <div class="form-group" >
			        <label>Referral's Last Name</label>
			        {{ Form::text('last_name') }}
			    </div>

			    @include('forms.phone', ['phone_label'=>"Referral's Phone Number"])

			    <div class="form-group" >
			        <label>Referral's Email</label>
			        {{ Form::text('email', null, array('class' => 'referral-email')) }}
			    </div>

			    @include('forms.address')

			    <div class="form-group">
			        <input type="checkbox" class="terms-acceptance" >
			        Terms!
			    </div>


			    <button type="submit" class="terms-button btn btn-primary button-responsive-100">Submit Referral</button>

			    {{ Form::close() }}
			</div>
		</div>
	</div>

@include('layouts.modal')

@endsection