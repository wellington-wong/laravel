@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h3><strong>Submit a New Referral</strong></h3>
                </div>
            </div>
        </div>
        @if( !$errors->isEmpty() )
            <div class="alert alert-warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{ Form::open(['route'=>'post-referral-create', 'id' => 'referral-create-form']) }}

        <input type="hidden" name="subdomain_id" value="2{{ $subdomain_id }}" >

        <div class="form-group" >
            <label>Referral's First Name</label>
            {{ Form::text('first_name', old('first_name'), ['placeholder' => 'Referral\'s First Name']) }}
        </div>

        <div class="form-group" >
            <label>Referral's Last Name</label>
            {{ Form::text('last_name', old('last_name'), ['placeholder' => 'Referral\'s First Name']) }}
        </div>

        @include('forms.phone', ['phone_label'=>"Referral's Phone Number"])

        <div class="form-group" >
            <label>Referral's Email</label>
            {{ Form::text('email', null, ['class' => 'referral-email', 'placeholder' => 'Referral\'s First Name']) }}
        </div>

        @include('forms.address')

        <div class="form-group">
            <input type="checkbox" class="terms-acceptance" >
            Terms!
        </div>


        <button type="submit" class="terms-button btn btn-primary button-responsive-100">Submit Referral</button>

        {{ Form::close() }}
    </div>

@include('layouts.modal')

@endsection