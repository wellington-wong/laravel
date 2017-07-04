@extends('layouts.app')

@section('pageTitle', 'Create User')

@section('content')
    <div class="container-fluid create-customer-wrapper">
    
        <div class="row">
        @include('layouts.page-header', ['header' => 'Create User', 'col' => 3])
        </div>

        <div class="clearfix"></div>

    </div>

@endsection