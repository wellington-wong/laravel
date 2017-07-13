@extends('layouts.app')

@section('pageTitle', auth()->user()->display_name)

@section('content')

    <div class="container-fluid manage-account-wrapper">

        <div class="row">
        @include('layouts.page-header', ['header' => auth()->user()->display_name, 'col' => 12])
            <div class="profile-preview text-center {{ isset(auth()->user()->profile_image) ? '' : 'hidden' }} col-md-12">
                <img class="img-responsive center-block" height="100" src="{{ isset(auth()->user()->profile_image) ? auth()->user()->profile_image : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}">
            </div>
        </div>
        
        <div class="row">            
            <div class="col-md-12 no-padding-lr">
    	        {{ Form::open(['route'=>'post-account-update', 'enctype' => 'multipart/form-data', 'id' => 'update-user-form', 'class' => 'update-form']) }}

    	        <div class="col-md-6">
    	        	{{ Form::text('name', auth()->user()->name, ['placeholder' => 'Name', 'class' => 'form-control' . ($errors->has('name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	{{ Form::text('email',  auth()->user()->email, ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('email') ? ' has-error' : ''), 'readonly']) }}            
    	        </div>

    	        @include('forms.address', ['address_placeholder' => 'Address'])

                <div class="col-md-6">
                    @include('forms.phone', ['phone_label'=>'Phone Number', 'placeholder' => 'Phone Number', 'no_col' => true, 'value' => (isset(auth()->user()->phone->first()->phone) ? auth()->user()->phone->first()->phone : '')])
                </div>

                <div class="form-group col-md-6">
                    <label for="profile-upload" class="btn btn-default upload-label">{{ isset(auth()->user()->profile_image) ? 'Update Profile Image' : 'Upload Profile Image' }}</label>
                    {{ Form::file('profile', array('class' => 'profile-upload hidden', 'id' => 'profile-upload', 'multiple' => 'multiple')) }}
                </div>    

                {{ Form::hidden('profile_blob', null, ['class' => 'profile-blob']) }}
                {{ Form::hidden('profile_blob_name', null, ['class' => 'profile-blob-name']) }}

    	        <div class="form-group col-md-12 text-right">
    	        	{{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100 submit-profile']) }}
    	        </div>

    	    	{{ Form::close() }}
            </div>

        </div>
    </div>

@endsection