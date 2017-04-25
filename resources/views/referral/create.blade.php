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

    {{ Form::open(['route'=>'post-referral-create']) }}

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
        {{ Form::text('last_name') }}
    </div>

    @include('forms.address')

    <div class="form-group">
        <input type="checkbox" class="terms-acceptance" >
        Terms!
    </div>


    <button type="submit" class="terms-button btn btn-primary button-responsive-100">Submit Referral</button>

    {{ Form::close() }}

@endsection