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

    {{ Form::open(['route'=>'post-company-create', 'id' => 'create-company-form', 'enctype' => 'multipart/form-data']) }}

    @include('forms.address')

    <div class="form-group col-md-6">
        {{ Form::text('company_name', old('company_name'), ['placeholder' => 'Company Name', 'class' => 'form-control']) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::text('subdomain', old('company_name'), ['placeholder' => 'Subdomain', 'class' => 'form-control']) }}
    </div>

    <div class="form-group">
        <label>Logo</label>
        {{ Form::file('logo', array('class' => 'logo-upload')) }}
    </div>

    @include('forms.phone', ['phone_label'=>'Company Phone Number'])

    <button type="submit" class="btn btn-primary button-responsive-100">Create Company</button>

    {{ Form::close() }}

@endsection