@extends('layouts.app')

@section('pageTitle', 'Email Template')

@section('content')
    <div class="container-fluid email-logs-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Email Template', 'col' => 12])
        </div>

        <div class="clearfix"></div>

        <div class="row">
        </div>

    </div>

@endsection