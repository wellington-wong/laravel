@extends('layouts.app')

@section('pageTitle', 'Create Referral')

@section('content')

    <div class="container-fluid create-referral">
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

        <div class="referral-create-form-wrapper">
            {{ Form::open(['route'=>'post-referral-create', 'id' => 'referral-create-form']) }}

            <input type="hidden" name="subdomain_id" value="2{{ $subdomain_id }}" >

            <div class="form-group col-md-6" >
                {{ Form::text('first_name', old('first_name'), ['placeholder' => 'Referral\'s First Name', 'class' => 'form-control' . ($errors->has('first_name') ? ' has-error' : '')]) }}
            </div>

            <div class="form-group col-md-6" >
                {{ Form::text('last_name', old('last_name'), ['placeholder' => 'Referral\'s Last Name', 'class' => 'form-control' . ($errors->has('last_name') ? ' has-error' : '')]) }}
            </div>

            @include('forms.phone', ['phone_label'=>'Referral\'s Phone Number', 'placeholder' => 'Referral\'s Phone Number'])

            <div class="form-group col-md-6" >
                {{ Form::text('email', old('email'), ['placeholder' => 'Referral\'s Email', 'class' => 'form-control referral-email' . ($errors->has('email') ? ' has-error' : '') ]) }}            
            </div>

            @include('forms.address')

            <div class="form-group col-md-12" >
                {{ Form::select('install_complete', ['' => 'Was your friend\'s new AC installation already complete?', '1' => 'Yes', '0' => 'No'], old('install_complete'), ['class' => 'form-control install-complete']) }}
            </div>

            <div class="form-group col-md-12 terms-wrapper">
                <label style="">
                <input type="checkbox" name="terms[]" class="terms-acceptance pull-left" @if(count($errors)) checked="checked" @endif>
                <div class="terms-details">
                    I understand that the receipt of the $100.00 Cash Reward is dependent on my referral's AC installation Status.
                    I am only entitled for a Referral Reward if/when this referral's AC Unit has been installed by All Year Cooling and Heating, Inc.
                    View our full <a href="#" class="terms-condition-link">terms and conditions</a>.
                </div>
                </label>
            </div>

            <div class="form-group col-md-12 text-center">
                <button type="submit" class="terms-button btn btn-primary button-responsive-100 submit-referral">Submit Referral</button>
            </div>

            {{ Form::close() }}
            <div class="clearfix"></div>
        </div>
        @include('layouts.modal')
    </div>

@endsection