@extends('layouts.app')

@section('pageTitle', 'Create Company')

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
                    <h3><strong>Create a Company</strong></h3>
                </div>
            </div>
        </div>
        <div class="create-company-wrapper">

            <div class="logo-preview text-center {{ old('logo_blob') ? '' : 'hidden' }}"><img class="img-responsive center-block" height="100" src="{{ old('logo_blob') ? : 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' }}"></div>

            {{ Form::open(['route'=>'post-company-create', 'id' => 'create-company-form', 'enctype' => 'multipart/form-data']) }}

            <div class="form-group col-md-6">
                {{ Form::text('company_name', old('company_name'), ['placeholder' => 'Company Name', 'class' => 'form-control' . ($errors->has('company_name') ? ' has-error' : '')]) }}
            </div>

            <div class="form-group col-md-6">
                {{ Form::text('subdomain', old('subdomain'), ['placeholder' => 'Subdomain', 'class' => 'form-control' . ($errors->has('subdomain') ? ' has-error' : '')]) }}
            </div>

            @include('forms.address', ['company_address' => true])

            @include('forms.phone', ['phone_label'=>'Referral\'s Phone Number', 'placeholder' => 'Company Phone Number'])

            <div class="form-group col-md-6">
                <label for="logo-upload" class="btn btn-default upload-label">{{ old('logo_blob_name') ? 'Filename: ' . old('logo_blob_name') : 'Upload Company Logo' }}</label>
                {{ Form::file('logo', array('class' => 'logo-upload hidden', 'id' => 'logo-upload')) }}
            </div>    

            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-primary button-responsive-100 submit-company">Submit Company</button>
            </div>

            {{ Form::hidden('logo_blob', old('logo_blob'), ['class' => 'logo-blob']) }}
            {{ Form::hidden('logo_blob_name', old('logo_blob_name'), ['class' => 'logo-blob-name']) }}

            {{ Form::close() }}
            <div class="clearfix"></div>
        </div>
    </div>

@endsection