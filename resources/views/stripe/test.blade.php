@extends('layouts.app')

@section('pageTitle', 'Stripe Test')

@section('content')

	{{ Form::open(['route' => 'stripe-test' , 'id' => 'stripe-test-form', 'class' => 'stripe-test-form']) }}
	{{ Form::close() }}

@endsection