@extends('layouts.app')

@section('pageTitle', 'Create User')

@section('content')
    <div class="container-fluid create-user-wrapper">    

        @if( !$errors->isEmpty() )
            <div class="alert alert-warning col-md-12">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
        @include('layouts.page-header', ['header' => 'Create User', 'col' => 12])
            <div class="profile-preview text-center col-md-12">
                <img class="img-responsive center-block user-placeholder" height="100" src="/images/avatar-placeholder.png">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">            
            <div class="col-md-12 no-padding-lr">
    	        {{ Form::open(['route'=>'post-account-update', 'enctype' => 'multipart/form-data', 'id' => 'update-user-form', 'class' => 'update-form']) }}

    	        <div class="col-md-6">
    	        	{{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control' . ($errors->has('name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="col-md-6">
    	        	@include('forms.phone', ['phone_label'=>'Phone Number', 'placeholder' => 'Phone Number', 'no_col' => true, 'value' => null])
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	{{ Form::text('email',  null, ['placeholder' => 'Company Email', 'class' => 'form-control company-email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
    	        </div>

    	        @include('forms.address', ['address_placeholder' => 'Address'])

                <div class="form-group col-md-6">
                    <label for="profile-upload" class="btn btn-default upload-label">{{ isset(auth()->user()->profile_image) ? 'Update Profile Image' : 'Upload Profile Image' }}</label>
                    {{ Form::file('profile', array('class' => 'profile-upload hidden', 'id' => 'profile-upload', 'multiple' => 'multiple')) }}
                </div>    

                {{ Form::hidden('profile_blob', null, ['class' => 'profile-blob']) }}
                {{ Form::hidden('profile_blob_name', null, ['class' => 'profile-blob-name']) }}

    	        <div class="form-group col-md-12 text-right">
    	        	{{ Form::submit('Create User', ['class' => 'btn btn-primary button-responsive-100 submit-create']) }}
    	        </div>

    	    	{{ Form::close() }}
            </div>

        </div>

    </div>

@endsection