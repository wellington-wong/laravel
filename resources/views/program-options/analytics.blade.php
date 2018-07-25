@extends('layouts.app')

@section('pageTitle', 'Analytics')

@section('content')
    <div class="container-fluid analytics-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Analytics', 'col' => 12])
        </div>
    </div>

@endsection