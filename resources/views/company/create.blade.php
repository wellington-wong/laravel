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

    {{ Form::open(['route'=>'post-company-create', 'id' => 'create-company-form']) }}

    @include('forms.address')

    <div class="form-group" >
        <label>Company Name</label>
        {{ Form::text('company_name') }}
    </div>

    <div class="form-group" >
        <label>Subdomain</label>
        {{ Form::text('subdomain') }}
    </div>

    <div class="form-group">
        <label>Logo</label>
        <input type="file" class="logo-upload" name="logo" />
    </div>

    @include('forms.phone', ['phone_label'=>'Company Phone Number'])

    <button type="submit" class="btn btn-primary button-responsive-100">Create Company</button>

    {{ Form::close() }}

@endsection