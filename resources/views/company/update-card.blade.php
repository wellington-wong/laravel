@extends('layouts.app')

@section('pageTitle', ucwords($_company->company_name) . ' Credit Card')

@section('content')

    <div class="container-fluid">

        <div class="row">
        @include('layouts.page-header', ['header' => ucwords($_company->company_name) . ' Credit Card', 'col' => 12])
        </div>

        <div class="row">
            <div class="col-md-12 no-padding-lr">
                {{ Form::open(['route'=>'company-update-card', 'id' => 'update-credit-card-form', 'enctype' => 'multipart/form-data']) }}

                <div class="col-md-12 form-group no-padding-lr">
                    <div class="form-control">
                        @if (isset($_company->card_brand) && isset($_company->card_last_four))
                        {{ isset($_company->card_brand) ? $_company->card_brand : 'Credit card' }} ending in {{ isset($_company->card_last_four) ? $_company->card_last_four : 'N/A' }}
                        @else
                        No credit card saved for {{ ucwords($_company->company_name) }}.
                        @endif
                    </div>
                </div>

                <div class="col-md-12 form-group no-padding-lr">       
                    <label for="card-element">
                      New Credit Card Number
                    </label>
                    <div id="card-element">
                    </div>
                    <div id="card-errors" class="hidden" role="alert"></div>
                </div>

                {{ Form::hidden('stripe_id', '') }}
                {{ Form::hidden('card_brand', '') }}
                {{ Form::hidden('card_last_four', '') }}
                <div class="form-group col-md-12 text-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary btn-update-card']) }}
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
@endsection