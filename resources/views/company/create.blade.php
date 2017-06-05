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
                <label for="logo-upload" class="btn btn-default">Upload Company Logo</label>
                {{ Form::file('logo', array('class' => 'logo-upload hidden', 'id' => 'logo-upload')) }}
            </div>    

            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-primary button-responsive-100 submit-company">Submit Company</button>
            </div>

            {{ Form::close() }}
            <div class="clearfix"></div>
        </div>
    </div>

@endsection