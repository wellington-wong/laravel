@extends('layouts.app')

@section('pageTitle', 'Stripe Test')

@section('content')

    <div class="row">
	   	<div class="col-md-12">
    		@include('layouts.page-header', ['header' => 'Stripe Test Charge', 'col' => 12])
   		</div>
    </div>

    <div class="row">
		{{ Form::open(['route' => 'post-stripe-test' , 'id' => 'stripe-test-form', 'class' => 'stripe-test-form']) }}
	        <div class="form-group">
	            <div class="col-md-12">
	              <div id="card-element"></div>
	              <div id="card-errors hidden" role="alert"></div>
	            </div>
	        </div>
	        <div class="form-group col-md-12">
	            <label>Amount to charge ($) *</label>
	            <div>
	                {{ Form::text('amount', '', array('class' => 'form-control', 'placeholder' => 'Amount to charge ($) *')) }}
	            </div>
	        </div>
	        {{ Form::hidden('stripe_id', '') }}
	        <div class="form-group col-md-12 text-right">
	        	{{ Form::submit('Submit', ['class' => 'btn btn-primary button-responsive-100 submit-charge']) }}
	        </div>
		{{ Form::close() }}
    </div>

@endsection