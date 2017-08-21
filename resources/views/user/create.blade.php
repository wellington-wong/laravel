@extends('layouts.app')

@section('pageTitle', 'Create User')

@section('content')
    <div class="container-fluid create-user-wrapper">    

        <div class="row">
        @include('layouts.page-header', ['header' => 'Create User', 'col' => 12])
            <div class="profile-preview text-center col-md-12">
                <img class="img-responsive center-block user-placeholder" height="100" src="/images/avatar-placeholder.png">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">            
            <div class="col-md-12 no-padding-lr">
    	        {{ Form::open(['route'=>'post-create-user', 'enctype' => 'multipart/form-data', 'id' => 'create-user-form', 'class' => 'create-user-form']) }}


                @role(['globalAdmin'])
                <div class="form-group col-md-12">
                    <label class="user-roles">Role</label>
                    {{ Form::select('user_role', ['' => 'Select A Role'] + $userRoles, null, ['class' => 'form-control']) }}
                </div>
                @endrole

    	        <div class="form-group col-md-6">
    	        	{{ Form::text('first_name', null, ['placeholder' => 'First Name', 'class' => 'form-control' . ($errors->has('first_name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="form-group col-md-6">
    	        	{{ Form::text('last_name', null, ['placeholder' => 'Last Name', 'class' => 'form-control' . ($errors->has('last_name') ? ' has-error' : '')]) }}
    	        </div>

    	        <div class="col-md-6">
    	        	@include('forms.phone', ['phone_label'=>'Phone Number', 'placeholder' => 'Phone Number', 'no_col' => true, 'value' => null])
    	        </div>

    	        <div class="form-group col-md-6" >
    	        	{{ Form::text('email',  null, ['placeholder' => 'Email', 'class' => 'form-control email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
    	        </div>

    	        @include('forms.address', ['address_placeholder' => 'Address'])

                <div class="form-group col-md-12">
                    <label for="profile-upload" class="btn btn-default upload-label">Upload Profile Image</label>
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