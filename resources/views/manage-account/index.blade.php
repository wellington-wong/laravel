@extends('layouts.app')

@section('pageTitle', auth()->user()->display_name)

@section('content')
{{ auth()->user()->phone }}
    <div class="container-fluid account-profile-wrapper">

        @include('layouts.page-header', ['header' => auth()->user()->display_name, 'col' => 12])

        <div class="row">
            <div class="col-md-12">
    	        {{ Form::open(['route'=>'post-account-update', 'id' => 'update-user-form', 'enctype' => 'multipart/form-data']) }}

    	        <div class="col-md-6">
    	        	{{ Form::text('name', auth()->user()->name, ['placeholder' => 'Name', 'class' => 'form-control' . ($errors->has('name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="col-md-6">
    	        	@include('forms.phone', ['phone_label'=>'Phone Number', 'placeholder' => 'Phone Number', 'no_col' => true, 'value' => ''])
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	{{ Form::text('email',  auth()->user()->email, ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
    	        </div>

    	        @include('forms.address', ['city' => null, 'address' => null, 'address2' => null, 'zip' => null, 'state' => null, 'address_placeholder' => 'Address'])


    	        <div class="form-group col-md-12 text-right">
    	        	{{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
    	        </div>

    	    	{{ Form::close() }}
            </div>

        </div>
    </div>

@endsection