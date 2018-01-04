@extends('layouts.app')

@section('pageTitle', 'Reviews')

@section('content')

    <div class="container-fluid">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Reviews', 'col' => 12])
        </div>
        <div class="clearfix"></div>
    </div>

@endsection