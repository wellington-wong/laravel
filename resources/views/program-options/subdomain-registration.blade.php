@extends('layouts.app')

@section('pageTitle', 'Subdomain Registration')

@section('content')
    <div class="container-fluid users-wrapper">
        <div class="row">
        @include('layouts.page-header', ['header' => 'Subdomain Registration', 'col' => 12])
        </div>
    </div>

@endsection