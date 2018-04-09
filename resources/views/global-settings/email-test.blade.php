@extends('layouts.app')

@section('pageTitle', 'Email Test')

@section('content')


    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Email Test', 'col' => 3])
        </div>

        <div class="clearfix"></div>


            <div class="row">
                <div class="col-md-6 no-padding-lr">
                    <div class="row">
                        <div class="col-md-8">
                            {{ Form::open(['method' => 'POST', 'id' => 'email-test-form', 'class' => 'email-test-form']) }}
                                {{ Form::text('receipient', '' , ['class' => 'form-control', 'placeholder' => 'Email Receipient']) }}            
                                {{ Form::submit('Send Test Email', ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
