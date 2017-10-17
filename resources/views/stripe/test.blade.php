@extends('layouts.app')

@section('pageTitle', 'Stripe Test')

@section('content')

	{{ Form::open(['route' => 'post-stripe-test' , 'id' => 'stripe-test-form', 'class' => 'stripe-test-form']) }}
        <div class="form-group col-md-12">
            <div class="col-md-12">
              <div id="card-element"></div>
              <div id="card-errors" role="alert"></div>
            </div>
        </div>
	{{ Form::close() }}

@endsection