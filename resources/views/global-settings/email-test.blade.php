@extends('layouts.app')

@section('pageTitle', 'Test Email')

@section('content')


    <div class="container-fluid members-wrapper">        

        <div class="row">
            @include('layouts.page-header', ['header' => 'Test Email', 'col' => 3])
        </div>

        <div class="clearfix"></div>

        {{ Form::open(['method' => 'POST', 'id' => 'email-test-form', 'class' => 'email-test-form']) }}                                
            <div class="row">
                <div class="form-group">                
                {{ Form::label('test_recipient', 'Email Recipient') }}            
                {{ Form::email('test_recipient', '' , ['class' => 'form-control', 'placeholder' => 'Email Recipient']) }}            
                </div>
            </div>                             
            <div class="row">
                <div class="form-group">
                {{ Form::label('test_email_body', 'Email Body') }}          
                {{ Form::textarea('test_email_body', '', ['class' => 'form-control tinymce']) }}
                </div>
            </div>               
            <div class="row">
                <div class="btn-group">           
                {{ Form::submit('Send Test Email', ['class' => 'btn btn-primary']) }}
                </div>
            </div>               
        {{ Form::close() }}
    </div>
@endsection
