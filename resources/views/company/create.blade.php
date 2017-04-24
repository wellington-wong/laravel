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

    {{ Form::open(['route'=>'post-company-create']) }}

    <div class="form-group">
        <label>Street Address</label>
        {{ Form::text('address') }}
    </div>

    <div class="form-group">
        <label>City</label>
        {{ Form::text('city') }}
    </div>

    <div class="form-group">
        <label>State</label>
        {{ Form::text('state') }}
    </div>

    <div class="form-group">
        <label>Zip Code</label>
        {{ Form::text('zip') }}
    </div>

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
        <input name="logo" >
    </div>

    <div class="form-group">
        <label>Company Phone Number</label>
        {{ Form::hidden('phone_country', 'US') }}
        {{-- Form::select('phone_country', \Propaganistas\LaravelIntl\Facades\Country::all(), 'US' ) --}}
        {{ Form::text('phone', null, ['class'=>'form-control bfh-phone', 'data-format'=>'(ddd) ddd-dddd']) }}
    </div>

    <button type="submit" class="btn btn-primary button-responsive-100">Create Company</button>


    {{ Form::close() }}

@endsection