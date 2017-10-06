@extends('layouts.app')

@section('pageTitle', ucwords($_company->company_name) . ' Credit Card')

@section('content')

    <div class="container-fluid company-profile-wrapper">

        <div class="row">
        @include('layouts.page-header', ['header' => ucwords($_company->company_name) . ' Credit Card', 'col' => 12])
        </div>

        <div class="row">
            <div class="col-md-12 no-padding-lr company-profile-left">
                {{ Form::open(['route'=>'post-company-update', 'id' => 'update-company-form', 'enctype' => 'multipart/form-data']) }}

                <div class="col-md-12 form-group">
                    <div class="form-control">
                        {{ isset(auth()->user()->card_brand) ? auth()->user()->card_brand : 'Credit card' }} ending in {{ isset(auth()->user()->card_last_four) ? auth()->user()->card_last_four : 'N/A' }}
                    </div>
                </div>

                <div class="col-md-12 form-group">       
                    <label for="card-element">
                      New Credit Card Number
                    </label>
                    <div id="card-element">
                    </div>
                    <div id="card-errors" class="hidden" role="alert"></div>
                </div>

                <div class="form-group col-md-12 text-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary button-responsive-100']) }}
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
@endsection